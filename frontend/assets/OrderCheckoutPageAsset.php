<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class OrderCheckoutPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        '/css/checkout.css?v=' . PROJECT_VERSION,

    ];
    public $js = [

        '/js/checkout-payment-methods.js?v=' . PROJECT_VERSION,

    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap5\BootstrapAsset',
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];
}
