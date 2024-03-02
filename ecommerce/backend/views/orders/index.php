<?php

use common\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;


/** @var yii\web\View $this */
/** @var backend\models\search\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">

    <?= GridView::widget([
        'id'=>'ordersTable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class
        ],
        'columns' => [
           

            [
                'attribute'=>'id',
                'contentOptions'=>[
                    'style'=>'width:60px'


                ]
                ],
                // [
                //     'attribute' => 'status',
                //     'filter' => Html::activeDropDownList($searchModel, 'status', \common\models\Orders::getStatusLabels(), [
                //         'class' => 'form-control',
                //         'prompt' => 'All'
                //     ]),
                //     'format' => ['orderStatus'],],
                
                [ 'attribute'=>'fullname',
                    'content'=> function($model){
                        return $model->firstname .' '.$model->lastname;
                    },
                    
                    ],
           
            'total_price:currency',
           
          
            
            'email:email',
           // 'transaction_id',
            //'pappal_order_id',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', \common\models\Orders::getStatusLabels(), [
                    'class' => 'form-control',
                    'prompt' => 'All'
                ]),
                'format' => ['orderStatus']
            ], [

                    'attribute'=>'created_at',
                    'format'=>['datetime'],
                    'contentOptions'=>[
                        'style'=>'white-space: nowrap',
        
        
                    ],],
                   
                   // 'created_by',
            [
                'class' => ActionColumn::className(),
                'template'=>'{view} {update} {delete}',
                'urlCreator' => function ($action, Orders $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
</div>

</div>
