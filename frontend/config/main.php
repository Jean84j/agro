<?php
define('PROJECT_VERSION', 33);

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'shop',
    'name' => 'AgroPro',
    'language' => 'uk-UA',
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => '/site',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // 'enableStrictParsing' => false,
            'rules' => [
                '/' => '/site/index',

                'catalog' => 'category/list',
                'catalog/<slug:[\w+-]*\w+>' => 'category/children',
                'product-list/<slug:[\w+-]*\w+>' => 'category/catalog',

//                'catalog/<slug:[\w+-]*\w+>/<page:\d+>' => 'category/index', //pagination
//                'catalog/<slug:[\w+-]*\w+>/<brand:[\w+-]*\w+>' => 'category/index',
//                'catalog/<slug:[\w+-]*\w+>' => 'category/index',

                'product/<slug:[\w+-]*\w+>' => 'product/view',

                'about' => 'about/view',
            ],
        ],
        
    ],
    'params' => $params,
];
