<?php

namespace backend\controllers;
use yii\web\UploadedFile;
use common\models\Prodects;
use backend\models\search\ProdectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\forbiddenHttpException;
use yii\helpers\FileHelper;

use yii;
/**
 * ProdectController implements the CRUD actions for Prodects model.
 */
class ProdectController extends Controller{
public function behaviors()
    //  {
    // return array_merge(
    //                 parent::behaviors(),
    //                 [
    //                     'verbs' => [
    //                         'class' => VerbFilter::className(),
    //                         'actions' => [
    //                             'delete' => ['POST'],
    //                         ],
    //                     ],
    //                 ]
    //             );
    //         }


//         return [
//             'access' => [
//                 'class' => AccessControl::class,
//                 'only' => ['special-callback'],
//                 'rules' => [
//                     [
//                         'actions' => ['special-callback'],
//                         'allow' => true,
//                         'matchCallback' => function ($rule, $action) {
//                             return date('d-m') === '31-10';
//                         }
//                     ],
//                 ],
//             ],
//        ];
    
//     }
// //  {  
    /**
    * @inheritDoc
     */
{
    return [
        'access' => [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => ['Prodect index'],
                ],
                [
                    'allow' => true,
                    'actions' => ['view'],
                    'roles' => ['Prodect view'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['Prodect create'],
                ],
                [
                    'allow' => true,
                    'actions' => ['update'],
                    'roles' => ['Prodect update'],
                ],
                [
                    'allow' => true,
                    'actions' => ['delete'],
                    'roles' => ['Prodect delete'],
                ],
            ],
        ],
    ];
}
//     /**
//      * @inheritDoc
//      */
//     public function behaviors()
//     {

            
//     //         // 'access' => [
                
//     //         //     'class' => AccessControl::className(),
//     //         //     'only' => ['admin'],
//     //         //     'rules' => [
//     //         //         [
//     //         //             'allow' => true,
//     //         //             'actions' => [], // applies to all actions
//     //         //             'roles' => ['admin'], // your defined roles
//     //         //             'denyCallback' => function ($rule, $action) {
//     //         //                 throw new \Exception('You are not allowed to access this page');
//     //         //             }
//     //         //         ],
                    
//     //         //         [
//     //         //             'allow' => true,
//     //         //             'actions' => [], // applies to all actions
//     //         //             'roles' => ['author'], // your defined roles
//     //         //             'denyCallback' => function ($rule, $action) {
//     //         //                 throw new \Exception('You are not allowed to access this page');
//     //         //             }
//     //         //         ],
                    
//     //         //     ],
//     //         //  ],






//             // 'access' => [
//             //     'class' => AccessControl::className(),
//             //     'only' => ['admin'],
//             //     'rules' => [
//             //         [
//             //             'allow' => true,
//             //             'actions' => ['admin'],
//             //             'roles' => ['admin'],
//             //         ],
//             //     ],
//             // ],
//      //   ];





        // return array_merge(
        //     parent::behaviors(),
        //     [
        //         'verbs' => [
        //             'class' => VerbFilter::className(),
        //             'actions' => [
        //                 'delete' => ['POST'],
        //             ],
        //         ],
        //     ]
        // );





    //     $behaviors['access']=[
    //         'class'=>AccessControl::className(),
    //          'rules'=>[
    //             [
    //             'allow'=>true,
    //             'roles'=>['@'],
    //             'matchCallback'=>function($rule,$action){

    //             $module =Yii::$app->controller->module->id;
    //             $action =Yii::$app->controller->action->id;
    //             $controller =Yii::$app->controller->id;
    //             $route= "$module/$controller/$action" ;
    //             $post=Yii::$app->request->post();
    //             if(\Yii::$app->user->can($route)){
    //                 return true;
    //             }


    //         }
                
            


    //            ],
    //     ],
    // ];
    //     return  $behaviors;
    

    /**
     * Lists all Prodects models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProdectsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Prodects model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Prodects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()

    {
        $model = new Prodects();
        $model->imageFile=UploadedFile::getInstance($model,'imageFile');
        //$this->created_by=getCretedBy();
        //$this->updated_by=Yii::$app->cretedBy->id;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Prodects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
     {
        //if (Yii::$app->user->can('update')) {
        // update post
    
        $model = $this->findModel($id);
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
         ]);
    
   // }else
        //     {
        //         \Yii::$app->getSession()->setFlash('error','gest admin can access here');
        //         return $this->redirect(['/site/index/']);

        //         //throw new forbiddenHttpException;
        //     }
    }
    
    /**
     * Deletes an existing Prodects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Prodects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Prodects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prodects::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
}