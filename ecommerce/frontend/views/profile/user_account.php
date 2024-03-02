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
                   your update account ok
                    </div>
                  <?php endif?>
             <?php $form = ActiveForm::begin([
                'action'=>['/profile/update-account'],
                'options'=>[
                    'data-pjax'=>1
                ]
            ]); ?>
            <div class="row">
               <div class="col-md-6">
               <?= $form->field($user, 'firstname')->textInput(['autofocus' => true]) ?>

               </div>

            
               <div class="col-md-6">
               <?= $form->field($user, 'lastname')->textInput(['autofocus' => true]) ?>

               

            </div>

            <?= $form->field($user, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($user, 'email') ?>

                <div class="col"><?= $form->field($user, 'password')->passwordInput() ?>
                </div>
                <div class="col"><?= $form->field($user, 'password_repeat')->passwordInput() ?>
                </div>

                

                <div class="form-group">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
          
    