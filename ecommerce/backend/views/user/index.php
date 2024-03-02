<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        //     ['class' => 'yii\grid\SerialColumn'],
                
                
        [

            'attribute'=>'id',
            'contentOptions'=>[
                'style'=>'width:100px'


            ],
        ],
            [ 'attribute'=>'name',
            'content'=> function($model){
                return $model->firstname .' '.$model->lastname;
            },
            
            ],
          
            // [

            //     'attribute'=>'admin',
            //     'contentOptions'=>[
            //         'style'=>'width:100px'


            //     ],
                
            //     'content'=>function($model){
            //         /** @var \common\models\User $model */
            //         return Html::tag('span',$model->admin ? 'access Dashbord' : 'No access Dashbord',
            //         ['class'=>$model->admin ? 'badge badge-success' : 'badge badge-danger'],);
            //     }
            // ],
            [
                'attribute' => 'admin',
                'contentOptions'=>[
                            'style'=>'width:100px'
        
        
                        ],
                'filter' => Html::activeDropDownList($searchModel, 'admin', \common\models\User::getUserLabels(), [
                    'class' => 'form-control',
                    'prompt' => 'All'
                ]),
                'format' => ['UserStatus']
            ],
            // 'username',
            // 'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'email:email',
            //'status',
            //'admin',
            //'created_at',
            //'updated_at',
            //'verification_token',
            [
                'class' => ActionColumn::className(),
                'template'=>' {update}' ,
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
