<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SpecialPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/css/view-options.css?v=' . PROJECT_VERSION,

    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];
}
