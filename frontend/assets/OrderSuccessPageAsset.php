<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class OrderSuccessPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/css/order-success.css?v=' . PROJECT_VERSION,
        '/css/order-list.css?v=' . PROJECT_VERSION,
        '/css/address-card.css?v=' . PROJECT_VERSION,
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
