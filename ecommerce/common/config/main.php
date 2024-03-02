<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],


    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    // 'modules' => [
    //         'auth' => [
    //             'class' => 'common\modules\auth\Module',
    //         ],
    //     ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        
        // 'authManager' => [
        //     'class' => 'yii\rbac\DbManager',
        //     // uncomment if you want to cache RBAC items hierarchy
        //     'cache' => 'cache',
        // ],

        'formatter' => [
            'class' => \common\i18n\Formatter::class,
            'datetimeFormat' => 'php:d/m/Y H:i',
        ]
    
    ],//GET https://api-m.sandbox.paypal.com/v1/oauth2/token
];
