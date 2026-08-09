<?php

namespace frontend\assets;

class OrderCheckoutPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/checkout.css',
    ];
    public $js = [

        'js/checkout-payment-methods.js',
    ];
    public $depends = [];

}
