<?php
define('PROJECT_VERSION', 81);

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'devicedetect'],
    'layout' => 'shop',
    'name' => 'Інтернет магазин Засобів Захисту Рослин AgroPro',
    'language' => 'uk',
    'timeZone' => 'Europe/Kiev',
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => '/site',
    'components' => [
        'devicedetect' => [
            'class' => 'alexandernst\devicedetect\DeviceDetect'
        ],
        'metamaster' => [
            'class' => 'floor12\metamaster\MetaMaster',
            'type' => 'website',
            'siteName' => 'AgroPro',
            'title' => 'AgroPro магазин',
            'description' => 'AgroPro магазин засобів захисту рослин',
            'defaultImage' => '/images/logos/meta_logo.jpg',
        ],
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
                     'levels' => [
                        'error',
//                        'warning',
//                        'info',
//                        'trace'
                    ],
                    'logVars' => [
//                        '_GET',
//                        '_POST',
//                        '_FILES',
//                        '_COOKIE',
//                        '_SESSION',
//                        '_SERVER'
                    ],
                ],
                [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'logVars' => [
//                        '_GET',
//                        '_POST',
//                        '_FILES',
//                        '_COOKIE',
//                        '_SESSION',
//                        '_SERVER'
                    ],

                    'message' => [
                        'from' => $params['email.from'],
                        'to'   => $params['email.admins'],
                        'subject' =>  YII_ENV_DEV ? 'Ошибка приложения LOCAL' : 'Ошибка приложения',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['uk', 'en', 'ru'],
            'enableDefaultLanguageUrlCode' => false,
            'enableLanguageDetection' => false,

            'enableLanguagePersistence' => false,

            'enableLocaleUrls' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',

                'catalog' => 'category/list',
                'catalog/<slug:[\w+-]*\w+>' => 'category/children',
                'product-list/<slug>/page/<page:\d+>' => 'category/catalog',
                'product-list/<slug:[\w+-]*\w+>' => 'category/catalog',

                'auxiliary-product-list/<slug>/page/<page:\d+>' => 'category/auxiliary-catalog',
                'auxiliary-product-list/<slug:[\w+-]*\w+>' => 'category/auxiliary-catalog',

                'product/<slug:[\w+-]*\w+>' => 'product/view',
                
                'post/<slug:[\w+-]*\w+>' => 'post/view',

                'about' => 'about/view',
                'delivery' => 'delivery/view',
                'contact' => 'contact/view',
                'compare' => 'compare/view',
                'wish' => 'wish/view',

                'tag' => 'tag/index',
                'tag/<id:\d+>' => 'tag/redirect',
                'tag/<slug>/<category_slug>/page/<page:\d+>' => 'tag/view',
                'tag/<slug>/page/<page:\d+>' => 'tag/view',
                'tag/<slug>/<category_slug>' => 'tag/view',
                'tag/<slug>' => 'tag/view',

                'special/page/<page:\d+>' => 'special/view',
                'special' => 'special/view',

                'blogs/page/<page:\d+>' => 'blogs/view',
                'blogs' => 'blogs/view',

                'brands' => 'brands/view',
                'brands/product-list/<slug>/page/<page:\d+>' => 'brands/catalog',
                'brands/product-list/<slug>' => 'brands/catalog',

                [
                    'pattern' => 'sitemap',
                    'route' => 'site-map/sitemap',
                    'suffix' => '.xml'
                ],
                [
                    'pattern' => 'sitemap-products',
                    'route' => 'site-map/sitemap-products',
                    'suffix' => '.xml'
                ],
                [
                    'pattern' => 'sitemap-categories',
                    'route' => 'site-map/sitemap-categories',
                    'suffix' => '.xml'
                ],
                [
                    'pattern' => 'sitemap-articles',
                    'route' => 'site-map/sitemap-articles',
                    'suffix' => '.xml'
                ],
                [
                    'pattern' => 'sitemap-pages',
                    'route' => 'site-map/sitemap-pages',
                    'suffix' => '.xml'
                ],
                [
                    'pattern' => 'sitemap-tags',
                    'route' => 'site-map/sitemap-tags',
                    'suffix' => '.xml'
                ],
                [
                    'pattern' => 'site-products-merchant-qlt5vh8de0rhf',
                    'route' => 'site-map/site-products-merchant',
                    'suffix' => '.xml'
                ],
            ],
        ],
         'i18n' => [
            'translations' => [
                'app*' => [
                    
                    'class' => 'frontend\components\DbMessageSource',
                    'sourceLanguage' => 'uk-UA',
                ],
                'home*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                    'sourceLanguage' => 'uk-UA',
                    'fileMap' => [
                        'home'      => 'home.php',
                        'home/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'uk-UA', // Локаль
            'defaultTimeZone' => 'Europe/Kiev', // Часовой пояс
            'currencyCode' => 'UAH', // Валюта
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ],
                ],
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
