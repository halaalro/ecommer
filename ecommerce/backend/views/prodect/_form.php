<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;

/** @var yii\web\View $this */
/** @var common\models\Prodects $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="prodects-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>




    <?= $form->field($model, 'imageFile',[

        'template'=>'
        
          <div class="custom-file"
         {input} 
         {label}
         {error}
        </div>
       
        ',
        'labelOptions'=>['class'=>'custom-file-label'],
        'inputOptions'=>['class'=>'custom-file-input']
    ])->fileInput(['type'=>'file']) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true,
    'type'=>'number',
    'step'=>'0.01']) ?>

    <?= $form->field($model, 'status')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
