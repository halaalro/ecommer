<?php

namespace frontend\controllers;
use yii\web\ForbiddenHttpException;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Prodects;
use yii\data\ActiveDataProvider;
use \common\models\UserAddress;

/**
 * Site controller
 */
class ProfileController extends \frontend\base\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'update-address','update-account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    
                ],
                
            ],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

  

   

    public function actionIndex()
    { /** @var \common\models\User $user */
        $user=Yii::$app->user->identity;
        $userAddress=$user->getAdress();
        
        
        
        return $this->render('index', [
            'user' => $user,
            'userAddress'=>$userAddress
        ]);
    }
    public function actionUpdateAddress()
    { /** @var \common\models\User $user */
        if(!Yii::$app->request->isAjax){

            throw new ForbiddenHttpException("You are only allowed to make ajax request");
        }
        $user=Yii::$app->user->identity;
        $userAddress=$user->getAdress();
        $success=false;
        
        if($userAddress->load(Yii::$app->request->post())&& $userAddress->save()){
            $success=true;


        }

        return $this->renderAjax('user_address',[
            'userAddress'=>$userAddress,
            'success'=>$success


        ]);
        
            
    }


    public function actionUpdateAccount()
    { /** @var \common\models\User $user */
        if(!Yii::$app->request->isAjax){

            throw new ForbiddenHttpException("You are only allowed to make ajax request");
        }
        $user=Yii::$app->user->identity;
        $success=false;
        
        if($user->load(Yii::$app->request->post())&& $user->save()){
            $success=true;


        }

        return $this->renderAjax('user_account',[
            'user'=>$user,
            'success'=>$success


        ]);
        
            
    }
}
