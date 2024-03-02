<?php

use common\models\Prodects;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\ProdectsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Prodects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prodects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="table-responsive">
    <p>
        <?= Html::a('Create Prodects', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'contentOptions'=>[
                'style'=>'width:60px'


            ]],
            [
                'attribute'=>'id',
                'contentOptions'=>[
                    'style'=>'width:60px'


                ]
                ],

            
            [

                'attribute'=>'image',
                'contentOptions'=>[
                    'style'=>'white-space: nowrap'


                ],
                'content'=>function($model){
                    /** @var \common\models\Prodects $model */
                    return Html::img($model->getImageUrl(),['style'=>'width:50px','hight:50px']);
                }
            ],
            
            [

                'attribute'=>'name',
                'contentOptions'=>[
                    'style'=>'white-space: nowrap'


                ],
                'content'=>function($model){
                    /** @var \common\models\Prodects $model */
                    return \yii\helpers\StringHelper::truncateWords( $model->name,7);
                
                }
                 
               ],
                'price:currency',
            // [

            //     'attribute'=>'status',
            //     'contentOptions'=>[
            //         'style'=>'width:20px'


            //     ],
                
            //     'content'=>function($model){
            //         /** @var \common\models\Prodects $model */
            //         return Html::tag('span',$model->status ? 'Active' : 'Drafe',
            //         ['class'=>$model->status ? 'badge badge-success' : 'badge badge-danger'],);
            //     }
            // ],
            [
                'attribute' => 'status',
                'contentOptions'=>[
                            'style'=>'width:100px'
        
        
                        ],
                'filter' => Html::activeDropDownList($searchModel, 'status', \common\models\Prodects::getProdectsLabels(), [
                    'class' => 'form-control',
                    'prompt' => 'All'
                ]),
                'format' => ['ProdectStatus']
            ],
            //'cretedBy.username',
            [

                'attribute'=>'created_at',
                'format'=>['datetime'],
                'contentOptions'=>[
                    'style'=>'white-space: nowrap',
    
    
                ],
               ],[

                'attribute'=>'updated_at',
                'format'=>['datetime'],
                'contentOptions'=>[
                    'style'=>'white-space: nowrap'
    
    
                ],
               ],
               
               
            [
                'class' => ActionColumn::className(),
                'contentOptions'=>[
                    'style'=>'white-space: nowrap'


                ],
                'urlCreator' => function ($action, Prodects $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div>
</div>
