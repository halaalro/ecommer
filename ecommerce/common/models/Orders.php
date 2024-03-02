<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $id
 * @property float $total_price
 * @property int $status
 * @property string $firstname
 * @property string $lastname
 * @property string $email 
 * @property string $transaction_id
 * @property string|null $pappal_order_id

 * @property int|null $created_at
 * @property int $created_by
 * @property OrderAddress $orderAddress;
 * @property OrderItems[] $orderItems;*/




class Orders extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    
    
  
    const STATUS_PAID = 1;
    const STATUS_FAILED = 2;
    const STATUS_COMPLETED = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total_price', 'firstname','lastname','email'], 'required'],
            [['total_price'], 'number'],
            [['status', 'created_by','created_at'], 'integer'],
           
            [['email'], 'email'],
            
            [['firstname', 'lastname'], 'string', 'max' => 45],
            [['email', 'transaction_id','pappal_order_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total_price' => 'Total Price',
            'status' => 'Status',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'transaction_id' => 'Transaction ID',
            'pappal_order_id' => 'Pappal Order Id',
            
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }
    public function getCretedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    } 
     /** 
     * @return \yii\db\ActiveQuery|\common\models\query\OrderItemsQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['order_id' => 'id']);
    } 
    /** 
     * @return \yii\db\ActiveQuery|\common\models\query\OrderAddressQuery
     */
    public function getOrderAddress()
    {
        return $this->hasOne(OrderAddress::class, ['order_id' => 'id']);
    }



    public function saveAddress($postData)
    {    
        $orderAddress=new OrderAddress();
        $orderAddress->order_id=$this->id;

        if($orderAddress->load($postData)&& $orderAddress->save()){
            return true;
       }
       throw new Exception("orderAddress not save: ".impload('<br>',$orderAddress->getFirstErrors()));

    }



    public function saveOrderItems()
    {

        $cartItems=CartItems::getItemsForUser(\Yii::$app->user->id);
        foreach($cartItems as $cartItem){
            $orderItem=new OrderItems();
            $orderItem->prodect_name=$cartItem['name'];
            $orderItem->prodect_id=$cartItem['id'];
           

            $orderItem->unit_price=$cartItem['price'];
            $orderItem->order_id=$this->id;
            $orderItem->quantity=$cartItem['quantity'];
            if(!$orderItem->save()){
                throw new Exception("order not save: ".impload('<br>',$orderItem->getFirstErrors()));
               
            }


        }

        return true;
    }
   

    public  function getItemsQuantity()
    {
        return $sum=CartItems::findBySql("
        SELECT
        SUM(quantity) FROM order_items WHERE order_id= :orderId",['orderId'=>$this->id])
        ->scalar();
    }
    public function sendEmailToVendor()
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'order_completed_vendor-html', 'text' => 'order_completed_vendor-text'],
                ['order' => $this]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo('halper@example.com')
            ->setSubject('New order has been made at ' . Yii::$app->name)
            ->send();
    }

    public function sendEmailToCustomer()
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'order_completed_customer-html', 'text' => 'order_completed_customer-text'],
                ['order' => $this]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Your orders is confirmed at ' . Yii::$app->name)
            ->send();
    }

    public static function getStatusLabels()
    {
        return [
            self::STATUS_PAID => 'Paid',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_DRAFT => 'Draft'
        ];
    }
    
}
