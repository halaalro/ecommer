<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Orders $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$orderAddress = $model->orderAddress;
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>




<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'total_price:currency',
            'status:orderStatus',
            'firstname',
            'lastname',
            'email:email',
            'transaction_id',
            'pappal_order_id',
            'created_at',
        ],
    ]) ?>

    <h4>Address</h4>
    <?= DetailView::widget([
        'model' => $orderAddress,
        'attributes' => [
            'address',
            'city',
            'state',
            'country',
            'zipcode',
        ],
    ]) ?>

    <h4>Order Items</h4>
    <table class="table table-sm">
        <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total Price</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($model->orderItems as $item): ?>
            <tr>
                <td>
                    <img src="<?php echo $item->protectBy ? $item->protectBy->getImageUrl() : \common\models\Prodects::formatImageUrl(null) ?>"
                         style="width: 50px;">
                </td>
                <td><?php echo $item->prodect_name ?></td>
                <td><?php echo $item->quantity ?></td>
                <td><?php echo Yii::$app->formatter->asCurrency($item->unit_price) ?></td>
                <td><?php echo Yii::$app->formatter->asCurrency($item->quantity * $item->unit_price) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>