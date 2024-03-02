<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AuthItem;
use common\models\AuthAssignment;
/** @var yii\web\View $this */
/** @var common\models\AuthItemChild $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="auth-item-child-form">

    
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    <!-- <?= $form->field($model, 'parent')->dropDownList(
                                       AuthAssignment::find()
                                       ->select(['item_name'])
                                       ->indexBy('item_name')
                                       ->column(),['prompt'=>'Select AuthAssignment']


    ); ?> -->
    
    <?= $form->field($model, 'parent')->dropDownList(
                                       AuthItem::find()
                                       ->select(['name'])
                                       ->indexBy('name')
                                       ->column(),['prompt'=>'Select AuthItem']


    ); ?> <?= $form->field($model, 'child')->dropDownList(
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
