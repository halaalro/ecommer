<?php
/** @var \common\models\User $user */
/** @var \common\models\UserAddress $userAddress */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>
<div class="body-content">
<div class="row h-100">
    

    <div class="col py-4 ">
    <div class="card">
        <div class="card-header">
        Adresses Information
           
        </div>
            <div class="card-body">
            
            <?php \yii\widgets\pjax::begin([
               'enablePushState'=>false
                  ])?>

                  <?php  echo $this->render('user_address',[

                     'userAddress'=>$userAddress
                      ])?>
                      <?php \yii\widgets\pjax::end()?>

             </div>


   </div>
     </div>
    





    <div class="col py-4 h-100">
    <div class="card">
        <div class="card-header">
        Account Information
        </div>
            <div class="card-body">
            <?php \yii\widgets\pjax::begin([
               'enablePushState'=>false
                  ])?>
            <?php  echo $this->render('user_account',[

           'user'=>$user
            ])?>
            <?php \yii\widgets\pjax::end()?>
            
    

   
             </div>
    
    


        </div>
    
    


    </div>
    
    </div>


</div>











