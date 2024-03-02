<?php 
/** @var array $items*/
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\BootstrapAsset;

?>

<div class="card">
    
    <div class="card-header">
           <h3>
            Your Cart Items
         </h3>
        </div>
    <div class="card-body">
        <?php if(!empty($items)):?>
    <table class="table table-hover">
    <thead>
        <tr>
        <th>Prodect</th>
        <th>Image</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Action</th>



        </tr>
    </thead>
    <tbody>
       <?php foreach ($items as $item):?>

       <tr data-id="<?php echo $item['id'] ?>"
       data-url="<?php echo  \yii\helpers\Url::to(['/cart/change-quantity']) ?>">
           <td><?php echo $item['name'] ?> </td>
           <td>
               <img src="<?php echo \common\models\Prodects::formatImageUrl($item['image']) ?>"
               style="width:50px;"
               >
           </td>
           <td><?php echo \yii::$app->formatter->asCurrency($item['price']) ?> </td>
           <td>
            <input type="number" class="form-control item-quantity" 
            style="width:70px" value="<?php echo$item['quantity'] ?>">
            
           
            </td>
           <td><?php echo \yii::$app->formatter->asCurrency($item['price']*$item['quantity'])?> </td>
           <td>
              <a > <?php echo \yii\helpers\Html::a('Delete',['/cart/delete','id'=> $item['id']],
              ['class'=>'btn btn-outline-danger btn-sm',
              'data-method'=>'post',
              'data-confirm'=>'Are You Sure You Want TO Remove This Prodect Frome Cart?'
              ])  ?> </a>
           </td>


       </tr>
       <?php endforeach;?>
    </tbody>




</table>



                <div class="card-footer p-4 pt-0 border-top-0 ">
                    <div class="text-center">     
                    <a class="btn btn-outline-dark mt-auto " 
                    href="<?php echo \yii\helpers\Url::to(['/cart/checkout'])?>"
                        > CheckOut</a>
                </div></div>
                <?php else:?>
                    <p class="text-muted text-center p-5"> There Are No Items In The Cart</p>
                <?php endif;?>
        

    </div>

</div>
