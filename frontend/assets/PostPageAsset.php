<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class PostPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        // '/vendor/bootstrap/css/bootstrap.min.css?v=' . PROJECT_VERSION,
        '/css/typography.css?v=' . PROJECT_VERSION,
        '/css/post-page.min.css?v=' . PROJECT_VERSION,
        
    ];
    public $js = [

        '/js/post-page.min.js?v=' .  PROJECT_VERSION,

    ];
    public $depends = [
        
        'yii\web\YiiAsset',
        
    ];
    public $cssOptions = [
        
        'type' => 'text/css',
        
    ];
}
