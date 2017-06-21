<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-Ru',              // Задаем язык для всего приложения    теперь указав в шаблоне <html lang="<?= Yii::$app->language  ">     язык будет автоматом подтягиваться
    'defaultRoute' => 'category/index',
    'modules' => [
            // модуль  с именем   'admin'
        'admin' => [
            'class' => 'app\modules\admin\Module',
                // Указываем в явном виде, какой шаблон использовать 
            'layout' => 'admin',
            'defaultRoute' => 'order/index'
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'VNn_u5i0GkSCwhCtpqCzXtx_Kce8BAs5',
            'baseUrl' => '',                                                // Задаем для ЧПУ
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
                // Для незарегистрированного пользователя автоматом перенаправляет на 'site/login'
                // Мы можем поменять (например на   контроллер  cart   экшн  index)
            //'loginUrl' => 'cart'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'category/<id:\d+>/page/<page:\d+>' => 'category/view',         // это правило для чпу страниц категорий    http://yii2.loc/category/29/page/2
                'category/<id:\d+>' => 'category/view',
                'product/<id:\d+>' => 'product/view',                           // это правило для чпу страницы карточки товара
                'search' => 'category/search',
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
