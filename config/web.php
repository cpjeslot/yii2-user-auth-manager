<?php

use yii\data\Pagination;
use yii\grid\GridView;
use yii\rbac\DbManager;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'user-auth-manager',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name'=>'User Auth Manager',
    'timeZone' => 'Asia/Calcutta',
    'defaultRoute' => 'site/index',
    'homeUrl'   => '/site',
    'controllerNamespace' => 'app\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'container' => [
        'definitions' => [
            GridView::class => [
                'tableOptions' => [
                    'class' => 'table table-boardered grid',
                ],
                'layout'=> '{items}<div class="float-start">{summary}</div><div class="float-end">{pager}</div>',
                'columns' => [
                    'filterInputOptions' => true,
                ],
            ],
            Pagination::class => [
                'pageSize' => 10,
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'request' => [
            'csrfParam' => '_csrf-app',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'HiukiRLIwkgtXjrSOG2V5ICcTgrmRgW1',
        ],
        'user' => [
            'identityClass' => 'app\modules\auth\models\User',
            'loginUrl' => ['auth/user/login'],
            'returnUrl'=> ['site'],
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-app', 'httpOnly' => true],
            //'authTimeout' => 1800, // auth expire 
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the app
            'name' => 'userAuthManager',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
            'transport' => [
                'scheme' => 'smtp',
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.connectithub.com',
                'username' => 'no-reply@connectithub.com',
                'password' => 'KH.bIAf,BZ88',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'IST',
            'timeZone' => 'Asia/Kolkata',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
        ],
    ],
    'params' => $params,
    'modules' => [
        'auth' => [
            'class' => 'app\modules\auth\Module',
        ],
    ],
    ///// Apply Global Filter Input Class and Placeholder in GRIDVIEW
    'on beforeRequest'  => function ($event) {
        \Yii::$container->set('yii\grid\DataColumn', [
            'filterInputOptions' => [
                'class'       => 'form-control',
                'placeholder' => 'Type to search...',
                'prompt' => 'Select Option'
            ],
        ]);
    },
    'as access' => [
        'class' => 'app\modules\auth\components\AccessControl',
        'allowActions' => [
            //'*',
            'auth/user/logout',
            'site/*',
            'auth/user/request-password-reset',
            'auth/user/reset-password',
            'auth/user/signup',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
