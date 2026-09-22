<?php

namespace frontend\assets;

class AccountPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/account-nav.css',
        'css/dashboard.css',
        'css/profile-card.css',
        'css/address-card.css',
        'css/card-table.css',

    ];
    public $js = [];
    public $depends = [];

}

