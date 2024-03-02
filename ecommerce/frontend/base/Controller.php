<?php

namespace frontend\base;
use \common\models\CartItems;


class Controller extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */

public function beforeAction($action){

    if(\yii::$app->user->isGuest){
        $cartItems=\Yii::$app->session->get(CartItems::SESSION_KEY,[]);
        $sum=0;
        foreach($cartItems as $cartitem){
            $sum+=$cartitem['quantity'];

    }}
    else{
        $sum=0;
        $sum+=CartItems::findBySql("
        SELECT SUM(quantity) FROM  cart_items WHERE created_by=:userId",['userId'=>\Yii::$app->user->id])
        ->scalar();
    }



    $this->view->params['cartItemCount']=$sum;
    
    


        return parent::beforeAction($action);

    }
     


}


?>
