<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class DeliveryPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/css/about.css?v=' . PROJECT_VERSION,
        '/css/typography.css?v=' . PROJECT_VERSION,
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
