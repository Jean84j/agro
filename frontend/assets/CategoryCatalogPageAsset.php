<?php

namespace frontend\assets;

class CategoryCatalogPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/filter.css',
        'css/filters-button.css',
        'css/nouislider.css',
        'css/view-options.css',
        'css/block-sidebar.css',
        'css/widget-filters.css',
    ];

    public $js = [
        'vendor/nouislider/nouislider.min.js',
        'js/price-filter.js',
        'js/offcanvas-filters.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}