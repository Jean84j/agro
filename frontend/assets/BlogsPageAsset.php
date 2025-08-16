<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BlogsPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/vendor/bootstrap/css/bootstrap.min.css?v=' . PROJECT_VERSION,
        '/css/block-sidebar.css?v=' . PROJECT_VERSION,
        '/css/widget-search.css?v=' . PROJECT_VERSION,

    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap5\BootstrapAsset',
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];
}
