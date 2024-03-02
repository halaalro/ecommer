
<?php
        /** @var  array $cartItems;*/
         /** @var  int $prodectQuntity*/
         /** @var  int $prodectPrice */
        /** @var  \common\models\Orders $order;*/
        /** @var  \common\models\OrderAddress $orderAddress;*/
        
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;


?>


<?php
    $form = ActiveForm::begin([
        'id'=>'checkout-form',
        //'action'=>['/cart/submit-order'],
    ]); ?>

<div class="row h-100">
    

    <div class="col py-4 ">
    

<div class="card ">
       <div class="card-header p-2">
           <h2> Adresses Information</h2>
        </div>
            <div class="card-body">
            
            
               <?= $form->field($order, 'firstname')->textInput(['autofocus' => true]) ?>
              
               <?= $form->field($order, 'lastname')->textInput(['autofocus' => true]) ?>

                <?= $form->field($order, 'email') ?>
   
             </div>


             </div>
    <div class="card mt-3">
        <div class="card-header">
            <h2>Account Information</h2>
        </div>
            <div class="card-body">
            
            
              <?= $form->field($orderAddress, 'address')?>
               <?= $form->field($orderAddress, 'city')?>
              <?= $form->field($orderAddress, 'state')?>
             <?= $form->field($orderAddress, 'country')?>
              <?= $form->field($orderAddress, 'zipcode')?>
        </div>
        </div>
     </div>


    <div class="col py-4 ">
    
    <div class="card">
    <div class="card-header p-2">
           <h2> Orders Summary</h2>
        </div>
        <div class="card-body">
            <hr><table class="table table-sm">
        <h5>Prodects</h5>

            <thead>
                <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($cartItems as $item):?>

<tr >
    
    <td>
        <img src="<?php echo \common\models\Prodects::formatImageUrl($item['image']) ?>"
        style="width:50px;"
        >
    </td>
    <td><?php echo $item['name'] ?> </td>
    <td>
    <?php echo$item['quantity'] ?>
     
    
     </td>
    <td><?php echo \yii::$app->formatter->asCurrency($item['total_price']) ?> </td>
   


</tr>
<?php endforeach;?>
                
            </tbody>
        <table class="table">
        
        <tr>
           <td>Total Prodects</td>
         

        <td class="text-rigth">
        <?php echo $prodectQuntity ?> 
        </td>
        </tr> <tr>
           <td>Total price</td>
         

        <td class="text-rigth">
        
        <?php echo \yii::$app->formatter->asCurrency($prodectPrice) ?> 
        </td>
        </tr>
     </table>
       <p class="text-center mp-3">
        <button class="btn btn-secondary">Checkout</button>


        </p>

               

        </div>

    </div>

      

    
      </div>


</div>
   
<?php ActiveForm::end(); ?>







