<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        YII_ENV_DEV ? '/css/mobile-header.css?v=' . PROJECT_VERSION : 'css/mobile-header.min.css?v=' . PROJECT_VERSION,
        YII_ENV_DEV ? '/css/style.css?v=' . PROJECT_VERSION : '/css/style.min.css?v=' . PROJECT_VERSION,
        YII_ENV_DEV ? '/css/widgets.css?v=' . PROJECT_VERSION : '/css/widgets.min.css?v=' . PROJECT_VERSION,

        '/vendor/owl-carousel/assets/owl.carousel.min.css?v=' . PROJECT_VERSION,
        '/vendor/fontawesome/css/all.min.css?v=' . PROJECT_VERSION,

    ];
    public $js = [

        YII_ENV_DEV ? '/js/number.js?v=' . PROJECT_VERSION : '/js/number.min.js?v=' . PROJECT_VERSION,
        YII_ENV_DEV ? '/js/header.js?v=' . PROJECT_VERSION : '/js/header.min.js?v=' . PROJECT_VERSION,
        YII_ENV_DEV ? '/js/main.min.js?v=' . PROJECT_VERSION : '/js/main.min.js?v=' . PROJECT_VERSION,
        YII_ENV_DEV ? '/js/collapse.js?v=' . PROJECT_VERSION : '/js/collapse.min.js?v=' . PROJECT_VERSION,

        '/vendor/bootstrap/js/bootstrap.bundle.min.js?v=' . PROJECT_VERSION,
        '/vendor/owl-carousel/owl.carousel.min.js?v=' . PROJECT_VERSION,

    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap5\BootstrapAsset',
    ];
    public $cssOptions = [
       'type' => 'text/css',
    ];
}
