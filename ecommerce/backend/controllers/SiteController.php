<?php

namespace backend\controllers;


use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use common\models\Order;
use common\models\OrderItem;
use common\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use common\models\Orders;
use common\models\OrderItems;



use yii\web\Response;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login','forget-password','error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout','index','view','updata','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    { $totalEarnings = Orders::find()->paid()->sum('total_price');
        $totalOrders = Orders::find()->paid()->count();
        $totalProducts = OrderItems::find()
            ->alias('oi')
            ->innerJoin(Orders::tableName() . ' o', 'o.id = oi.order_id')
            ->andWhere(['o.status' => [Orders::STATUS_PAID, Orders::STATUS_COMPLETED]])
            ->sum('quantity');
        $totalUsers = User::find()->andWhere(['status' => User::STATUS_ACTIVE])->count();

        $orders = Orders::findBySql("
                        SELECT
                            CAST(DATE_FORMAT(FROM_UNIXTIME(o.created_at), '%Y-%m-%d %H:%i:%s') as DATE) as `date`,
                            SUM(o.total_price) as `total_price`
                            FROM orders o
                        WHERE o.status IN (" . Orders::STATUS_PAID . ", " . Orders::STATUS_COMPLETED . ")
                        GROUP BY CAST(DATE_FORMAT(FROM_UNIXTIME(o.created_at), '%Y-%m-%d %H:%i:%s') as DATE)
                        ORDER BY o.created_at")
            ->asArray()
            ->all();
        // Line Chart
        $earningsData = [];
        $labels = [];
        if (!empty($orders)) {
            $minDate = $orders[0]['date'];
            $orderByPriceMap = ArrayHelper::map($orders, 'date', 'total_price');
            $d = new \DateTime($minDate);
            $nowDate = new \DateTime();
            while ($d->getTimestamp() < $nowDate->getTimestamp()) {
                $label = $d->format('d/m/Y');
                $labels[] = $label;
                $earningsData[] = (float)( $orderByPriceMap[$d->format('Y-m-d')] ?? 0 );
                $d->setTimestamp($d->getTimestamp() + 86400);
            }
        }

        // Pie Chart
        $countriesData = Orders::findBySql("
        SELECT country,
               SUM(total_price) as total_price
        FROM orders o
                 INNER JOIN order_address oa on o.id = oa.order_id
        WHERE o.status IN (" . Orders::STATUS_PAID . ", " . Orders::STATUS_COMPLETED . ")
        GROUP BY country
    ")
        ->asArray()
        ->all();

    $countryLabels = ArrayHelper::getColumn($countriesData, 'country');

    $colorOptions = ['#4e73df', '#1cc88a', '#36b9cc'];
    $bgColors = [];
    foreach ($countryLabels as $i => $country) {
        $bgColors[] = $colorOptions[$i % count($colorOptions)];
    }


    return $this->render('index', [
        'totalEarnings' => $totalEarnings,
        'totalOrders' => $totalOrders,
        'totalProducts' => $totalProducts,
        'totalUsers' => $totalUsers,
        'data' => $earningsData,
        'labels' => $labels,
        'countries' => $countryLabels,
        'bgColors' => $bgColors,
        'countriesData' => ArrayHelper::getColumn($countriesData,'total_price'),
    ]);
}



    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionForgetPassword()
    {
        return "forget password";
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
