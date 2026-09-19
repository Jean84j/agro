<?php

namespace frontend\assets;

/**
 * Main application asset bundle.
 */
class AppAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        YII_ENV_DEV ? 'css/mobile-header.css' : 'css/mobile-header.min.css',
        YII_ENV_DEV ? 'css/style.css' : 'css/style.min.css',
        YII_ENV_DEV ? 'css/widgets.css' : 'css/widgets.min.css',

        YII_ENV_DEV ? 'css/account-menu.css' : 'css/account-menu.min.css',
        YII_ENV_DEV ? 'css/description_page.css' : 'css/description_page.min.css',


        'vendor/owl-carousel/assets/owl.carousel.min.css',
        'vendor/fontawesome/css/all.min.css',
    ];

    public $js = [
        YII_ENV_DEV ? 'js/number.js' : 'js/number.min.js',
        YII_ENV_DEV ? 'js/header.js' : 'js/header.min.js',
        YII_ENV_DEV ? 'js/main.js' : 'js/main.min.js',
        YII_ENV_DEV ? 'js/collapse.js' : 'js/collapse.min.js',

        YII_ENV_DEV ? 'js/description_page.js' : 'js/description_page.min.js',

        'vendor/owl-carousel/owl.carousel.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}