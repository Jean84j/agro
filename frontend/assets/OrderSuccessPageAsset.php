<?php

namespace frontend\assets;

class OrderSuccessPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/order-success.css',
        'css/order-list.css',
        'css/address-card.css',
    ];
    public $js = [];
    public $depends = [];

}
