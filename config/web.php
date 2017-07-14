<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'yummy',
    'name'=> 'Yummy',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ggtyuy54687346768thte5467h',
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'anggadarkprince@gmail.com',
                'password' => 'Angga17kireina',
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'about' => 'site/about',
                'contact' => 'site/contact',
                'tag/<slug:[0-9a-zA-Z\-]+>' => 'tag/recipe',
                'category/<slug:[0-9a-zA-Z\-]+>' => 'category/recipe',
                'recipe' => 'recipe/index',
                'recipe/create' => 'recipe/create',
                'recipe/<slug:[0-9a-zA-Z\-]+>' => 'recipe/view',
                'cooking' => 'cooking/index',
                'diet' => 'diet/index',
                'discovery' => 'discovery/index',
                'blog' => 'article/index',
                'blog/tag/<slug:[0-9a-zA-Z\-]+>' => 'tag/article',
                'blog/<slug:[0-9a-zA-Z\-]+>' => 'category/article',
                'blog/<year:[0-9]+>/<month:[0-9]+>' => 'article/archive',
                'article/<slug:[0-9a-zA-Z\-]+>' => 'article/view',
                '<username:[0-9a-zA-Z\-]+>' => 'user/view',
                '<username:[0-9a-zA-Z\-]+>/favorites' => 'user/favorites',
                '<username:[0-9a-zA-Z\-]+>/made' => 'user/made',
                '<username:[0-9a-zA-Z\-]+>/following' => 'user/following',
                '<username:[0-9a-zA-Z\-]+>/followers' => 'user/followers',
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'linkAssets' => true,
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'sass' => ['css', 'sassc {from} {to} --no-color'],
                    'ts' => ['js', 'tsc --out {to} {from}'],
                ],
            ],
        ],
    ],
    'defaultRoute' => 'site',
    'controllerMap' => [
        // declares "account" controller using a class name
        'account' => 'app\controllers\UserController',

        // declares "magazine" controller using a configuration array
        'magazine' => [
            'class' => 'app\controllers\PostController',
            'enableCsrfValidation' => false,
        ],
    ],
    'params' => $params,
    'timeZone' => 'Asia/Jakarta',
    'version' => '1.0',
    'layout' => 'main'
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
