<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class PostPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/css/typography.css?v=' . PROJECT_VERSION,
        '/css/post-page.min.css?v=' . PROJECT_VERSION,
        
    ];
    public $js = [

        YII_ENV_DEV ? '/js/post-page.js?v=' . PROJECT_VERSION : '/js/post-page.min.js?v=' . PROJECT_VERSION,

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
