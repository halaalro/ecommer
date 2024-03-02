<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AuthItem;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\AuthAssignment $model */

/** @var yii\widgets\ActiveForm $form */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    <?= $form->field($model, 'user_id')->dropDownList(
                                       User::find()
                                       ->where(['admin'=>1])
                                       ->select(['username','id'])
                                       ->indexBy('id')
                                       ->column(),['prompt'=>'Select User']


    ); ?>
    <?= $form->field($model, 'item_name')->dropDownList(
                                       AuthItem::find()
                                       ->select(['name'])
                                       ->indexBy('name')
                                       ->column(),['prompt'=>'Select AuthItem']


    ); ?>
    
  



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
