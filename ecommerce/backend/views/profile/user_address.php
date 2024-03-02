<?php
/** @var \common\models\User $user */
/** @var \common\models\UserAddress $userAddress */
/** @var yii\web\View $this */
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

?>



<?php 
if (isset($success)&&$success):?>

<div class="alert alert-success">
your update adddresss ok  
</div>
</div>
<?php endif?>


            <?php $addresform = ActiveForm::begin([
                'action'=>['/profile/update-address'],
                'options'=>[
                    'data-pjax'=>1
                ]
            ]); ?>

   
    <?= $addresform->field($userAddress, 'address')?>
    <?= $addresform->field($userAddress, 'city')?>
    <?= $addresform->field($userAddress, 'state')?>
    <?= $addresform->field($userAddress, 'country')?>
    <?= $addresform->field($userAddress, 'zipcode')?>
    <button class="btn btn-primary">Upload</button>
    

    <?php ActiveForm::end(); ?>
   