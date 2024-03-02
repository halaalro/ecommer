<?php
namespace frontend\controllers;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\Request;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use yii\web\Controller;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Prodects;
use yii\data\ActiveDataProvider;
use \common\models\UserAddress;
use \common\models\CartItems;
use \common\models\Orders;
use \common\models\OrderAddress;





/**
 * Cart controller
 */
class CartController extends \frontend\base\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => ContentNegotiator::class,
                'only' => ['add','create-order','change-quantity','submit-paypal'],
                'formats'=> [
                    'application/json' => Response::FORMAT_JSON,
                ],
                
                
                       
                        
            ],
            ['class'=>VerbFilter::class,
            'actions'=>[
                'delete'=>['POST','DELETE'],
                'create-order'=>['POST'],

            ]]

            
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

  

   

    public function actionIndex()
    { 
        $cartItems=CartItems::getItemsForUser(\Yii::$app->user->id);

    return $this->render('index',[
        'items'=>$cartItems,
        


    ]);
    }


    public function actionAdd(){

        $id =\yii::$app->request->post('id');
        $prodect=Prodects::find()->id($id)->published()->one();
        if(!$prodect){

            throw new NotFoundHttpException();
        }
        $Cart=CartItems::find()->andWhere(['product_id'=>$id,'created_by'=>\yii::$app->user->id])->one();
        
        


        if(\yii::$app->user->isGuest){
        
              $cartItems=\Yii::$app->session->get(CartItems::SESSION_KEY,[]);
              $fond=false;
              foreach($cartItems as &$item){
                 if($item['id']==$id){
                    $item['quantity']++;
                     $fond=true;
                     break;
                   }
            }
              if(!$fond){
                $cartitem=[  
                    
                   'id'=>$id,
                   'name'=>$prodect->name,
                   'image'=>$prodect->image,
                   'price'=>$prodect->price,
                   'quantity'=>1,
                   
                   'total_price' =>$prodect->price,
                   
                    
                   
               
                 ];
               
                 $cartItems[]=$cartitem;
               


        }
        
        
        \Yii::$app->session->set(CartItems::SESSION_KEY,$cartItems);

        }







        else{
        if(!$Cart){
            $cartItem=new CartItems();
            $cartItem->product_id=$id;
            $cartItem->created_by=\yii::$app->user->id;
            $cartItem->quantity=1;
            $cartItem->save();
            

           }
           elseif($Cart->quantity== CartItems::Quantity){
            $quantitynew= $Cart->quantity+1;
            $Cart->delete();
            $cartItem=new CartItems();
            $cartItem->product_id=$id;
            $cartItem->created_by=\yii::$app->user->id;
            $cartItem->quantity=$quantitynew;
            $cartItem->save();

           } 
        
        }
        
       
    }
    public function actionDelete($id){

        if(\yii::$app->user->isGuest){
            $cartItems=\Yii::$app->session->get(CartItems::SESSION_KEY,[]);
            foreach($cartItems as $i=>$cartitem){
                if($cartitem['id']==$id){
                   array_splice($cartItems,$i,1);
                    break;
                  }
           }
           \Yii::$app->session->set(CartItems::SESSION_KEY,$cartItems);

        }else{
            CartItems::deleteAll(['product_id'=>$id,'created_by'=>\yii::$app->user->id]);


        }
    return $this->redirect(['index']);
    }


    
    public function actionChangeQuantity(){

        $id =\yii::$app->request->post('id');
        $prodect=Prodects::find()->id($id)->published()->one();
        if(!$prodect){

            throw new NotFoundHttpException();
        }
        $quantity =\yii::$app->request->post('quantity');
        if(\yii::$app->user->isGuest){
        
            $cartItems=\Yii::$app->session->get(CartItems::SESSION_KEY,[]);
            foreach($cartItems as &$cartItem){
                if($cartItem['id']===$id){
                    $cartItem['quantity']=$quantity;
                    break;
                }
            }
            \Yii::$app->session->set(CartItems::SESSION_KEY,$cartItems);

        }

        else{
            $Cart=CartItems::find()->userId(\yii::$app->user->id)->prodectId($id)->one();
            if($Cart){
                $Cart->quantity=$quantity;
                $Cart->save();


                



            }


        }
        return [
            'quantity'=>CartItems::getTotalQuantityForUser(\yii::$app->user->id),
            'price'=>Yii::$app->formatter->asCurrency(CartItems::getTotalPriceForItemForUser($id,\yii::$app->user->id))
            
        ];
    }

    
    public function actionCheckout(){
        $cartItems=CartItems::getItemsForUser(\Yii::$app->user->id);
        $prodectQuntity=CartItems::getTotalQuantityForUser(\yii::$app->user->id);
        $prodectPrice=CartItems::getTotalPriceForUser(\yii::$app->user->id);
       if(empty($cartItems)){
        return $this->redirect(['/site/index']);

       }

        

        $order= new Orders;
        $order->total_price=$prodectPrice;
        $order->status=Orders::STATUS_DRAFT;
        $order->created_at = time();
        $order->created_by=\yii::$app->user->id;
        $tracsection=Yii::$app->db->beginTransaction();

        if($order->load(Yii::$app->request->post())
           && $order->save()
           && $order->saveAddress(Yii::$app->request->post())
           && $order->saveOrderItems()){
            $tracsection->commit();
            CartItems::clearCartItems(\Yii::$app->user->id);
           


            return $this->render('pay-now',[

                'order'=>$order,
                
                
            ]);
            }
        $orderAddress=new OrderAddress();

        if(!\yii::$app->user->isGuest){
        /** @var  \common\models\User $user;*/
        $user=Yii::$app->user->identity;
        $userAddress= $user->getAdress();


         $order->firstname=$user->firstname;
         $order->lastname=$user->lastname;
         $order->email=$user->email;
         $order->status=Orders::STATUS_DRAFT;


         $orderAddress->address= $userAddress->address;
         $orderAddress->city= $userAddress->city;
         $orderAddress->state= $userAddress->state;
         $orderAddress->country= $userAddress->country;
         $orderAddress->zipcode= $userAddress->zipcode;

        }

       


        


        return $this->render('checkout',[
            'order'=>$order,
            'orderAddress'=>$orderAddress,
            'cartItems'=>$cartItems,
            'prodectQuntity'=>$prodectQuntity,
            'prodectPrice'=>$prodectPrice,
            
    
    
        ]);

    }



    public function actionSubmitPaypal($orderId){

        $where = ['id' => $orderId, 'status' => Orders::STATUS_DRAFT];
        if (!\yii::$app->user->isGuest){
            $where['created_by'] =\yii::$app->user->id;
        }
        $order = Orders::findOne($where);
        if (!$order){
            throw new NotFoundHttpException();
        }

        $req = Yii::$app->request;
        $pappalOrderId = $req->post('orderId');
        $exists = Orders::find()->andWhere(['pappal_order_id' => $pappalOrderId])->exists();
        if ($exists) {
            throw new BadRequestHttpException();
        }
       // $clintid="AWqEbtaA8p6cxuPN5w3vmg_GK0Nk2Ox6efPUTSACMSb6Q5OKQJ9iuek1T-LtPJny0O_8bMsoMwv0MBep";
       // $clintsecrit="EHGjvLKtCbwohA3YULYohE1VHC9gh-xizmY5h7xiWO2dGYx5fkwxVyXVUfAn8MJjp8N_sd0qJ7oJxnXJ";
        $environment = new SandboxEnvironment(Yii::$app->params['paypalClientId'], Yii::$app->params['paypalSecret']);
         $client = new PayPalHttpClient($environment);
        
        $response = $client->execute(new OrdersGetRequest($pappalOrderId));

        // @TODO Save the response information in logs
        if ($response->statusCode === 200) {
            $order->pappal_order_id = $pappalOrderId;
            $paidAmount = 0;
            foreach ($response->result->purchase_units as $purchase_unit) {
                if ($purchase_unit->amount->currency_code === 'USD') {
                    $paidAmount += $purchase_unit->amount->value;
                }
            }
            if ($paidAmount === (float)$order->total_price && $response->result->status === 'COMPLETED') {
                $order->status = Orders::STATUS_COMPLETED;
            }
            $order->transaction_id = $response->result->purchase_units[0]->payments->captures[0]->id;
            
            if  ($order->save()) {
                if (!$order->sendEmailToVendor()) {
                    Yii::error("Email to the vendor is not sent");
                }
                if (!$order->sendEmailToCustomer()) {
                    Yii::error("Email to the customer is not sent");
                }

                return [
                    'success' => true
                ];
            } else {
                Yii::error("Order was not saved. Data: ".VarDumper::dumpAsString($order->toArray()).
                    '. Errors: '.VarDumper::dumpAsString($order->errors));
            }  
        }

        throw new BadRequestHttpException();

    }








   // public function actionCreateOrder(){
        // $transactionId=Yii::$app->request->post('transactionId');
        // $status=Yii::$app->request->post('status');

        // $total_price=CartItems::getTotalQuantityForUser(\yii::$app->user->id);
        // if($total_price === null){

        //     throw new BadRequestHttpException();
        // }
        // $order=new Orders();
        // $order->transaction_id=$transactionId;
        // $order->total_price=$total_price;
        // $order->status=$status === 'COMPLETED' ? Orders::STATUS_COMPLEATED : Orders::STATUS_FAILURED;
        // $order->created_by=\yii::$app->user->id;
        // $tracsection=Yii::$app->db->beginTransaction();

        // if($order->load(Yii::$app->request->post())
        //    && $order->save()
        //    && $order->saveAddress(Yii::$app->request->post())
        //    && $order->saveOrderItems()){
        //     $tracsection->commit();
        //     CartItems::clearCartItems(\Yii::$app->user->id);


        //         return[
        //             'success'=>true
        //         ];
        //     }else{
        //         $tracsection->rollBack;

        //         return[
        //             'success'=>false,
        //             'errors'=>$orderAddress->errors
        //         ];

        //     }
        



    


    //}
}

     

