<?php

if (YII_ENV == "dev") {
    $params = require(__DIR__ . '/params_test.php');
} else {
    $params = require(__DIR__ . '/params.php');
}

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'defaultRoute'=>'/mainmod/main/index',
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Shanghai',
    'modules' => [
        'mainmod' => [//主页模块
            'class' => 'app\modules\main\main',
        ],
        'ordersmod' => [//订单模块
            'class' => 'app\modules\orders\orders',
        ],
        'tools' => [//工具模块
            'class' => 'app\modules\tools\tools',
        ],
        'usermod' => [//会员模块
            'class' => 'app\modules\user\user',
        ],
        'adminmod' => [//管理用户模块
            'class' => 'app\modules\admin\admin',
        ],
        'productmod' => [//产品模块
            'class' => 'app\modules\product\product',
        ],
        'cron' => [
            'class' => 'app\modules\cron\cron',
        ],
        'websitemod' => [//网站管理模块
            'class' => 'app\modules\website\website',
        ],
        'front' => [//前台页面模块
            'class' => 'app\modules\front\front',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'goodluck2017',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
                'application/xml' => 'yii\web\XmlParser',
                'text/xml' => 'yii\web\XmlParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        //邮件配置
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
//            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.qq.com',
                'username' => '1028617248@qq.com',//发送者邮箱地址
                'password' => 'fmqfwsfttzlbbcjf', //SMTP密码
                'port' => '25',
                'encryption' => 'tls',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['1028617248@qq.com'=>'system']
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
        'db' => require(__DIR__ . '/db.php'),
        'redis' => require(__DIR__ . '/redis.php'),
        /*
          'urlManager' => [
          'enablePrettyUrl' => true,
          'showScriptName' => false,
          'rules' => [
          ],
          ],
         */
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => [
//                 '<modules:\w+>/<controller:\w+>/<action:\w+>/<code:\w+>'=>'<modules>/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
//            'allowedIPs' => ['127.0.0.1', '::1','119.23.239.189'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
//            'allowedIPs' => ['127.0.0.1', '::1','119.23.239.189'],
    ];
}

return $config;
