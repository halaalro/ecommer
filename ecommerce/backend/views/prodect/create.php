<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Prodects $model */

$this->title = 'Create Prodects';
$this->params['breadcrumbs'][] = ['label' => 'Prodects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prodects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
