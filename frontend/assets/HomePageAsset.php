<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class HomePageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/vendor/bootstrap/css/bootstrap.min.css?v=' . PROJECT_VERSION,
        '/css/category-card.css?v=' . PROJECT_VERSION,
        '/css/block-posts.css?v=' . PROJECT_VERSION,
        '/css/block-product-columns.css?v=' . PROJECT_VERSION,
        '/css/block-features.css?v=' . PROJECT_VERSION,
        '/css/block-banner.css?v=' . PROJECT_VERSION,
        '/css/block-brands.css?v=' . PROJECT_VERSION,
        '/css/block-products.css?v=' . PROJECT_VERSION,
        '/css/block-slideshow.css?v=' . PROJECT_VERSION,
        '/css/block-categories.css?v=' . PROJECT_VERSION,

    ];
    public $js = [

        '/js/block-brands-carousel.js?v=' . PROJECT_VERSION,
        '/js/block-posts-carousel.js?v=' . PROJECT_VERSION,

    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap5\BootstrapAsset',
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];
}
