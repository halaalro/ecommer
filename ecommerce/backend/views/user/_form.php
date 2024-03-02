<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form ->field ($model,'admin') ->dropDownList([1=>'Access', 0=>'not access'])?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
