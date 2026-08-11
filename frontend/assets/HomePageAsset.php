<?php

namespace frontend\assets;

class HomePageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/category-card.css',
        'css/block-posts.css',
        'css/block-product-columns.css',
        'css/block-features.css',
        'css/block-banner.css',
        'css/block-brands.css',
        'css/block-products.css',
        'css/block-slideshow.css',
        'css/block-categories.css',

    ];
    public $js = [

        'js/block-brands-carousel.js',
        'js/block-posts-carousel.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
