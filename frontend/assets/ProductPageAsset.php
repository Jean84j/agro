<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ProductPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/css/product-page.min.css?v=' . PROJECT_VERSION,
        '/vendor/photoswipe/photoswipe.css?v=' . PROJECT_VERSION,
        '/vendor/photoswipe/default-skin/default-skin.css?v=' . PROJECT_VERSION,
    ];
    public $js = [
        
        '/js/product-page.min.js?v=' . PROJECT_VERSION,
        '/vendor/photoswipe/photoswipe.min.js?v=' . PROJECT_VERSION,
        '/vendor/photoswipe/photoswipe-ui-default.min.js?v=' . PROJECT_VERSION,

    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap5\BootstrapAsset',
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];
    
     public $jsOptions = [
        // 'defer' => true,
    ];
}
