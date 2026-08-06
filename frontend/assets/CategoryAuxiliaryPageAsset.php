<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CategoryAuxiliaryPageAsset extends AssetBundle
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
    ];

}
