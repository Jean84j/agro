<?php

namespace frontend\assets;

class ProductPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/product-page.min.css',
        'vendor/photoswipe/photoswipe.css',
        'vendor/photoswipe/default-skin/default-skin.css',
    ];
    public $js = [

        YII_ENV_DEV ? 'js/product-page.js' : 'js/product-page.min.js',

        'vendor/photoswipe/photoswipe.min.js',
        'vendor/photoswipe/photoswipe-ui-default.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
