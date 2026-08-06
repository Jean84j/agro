<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BlogsPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/css/block-sidebar.css?v=' . PROJECT_VERSION,
        '/css/widget-search.css?v=' . PROJECT_VERSION,

    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
