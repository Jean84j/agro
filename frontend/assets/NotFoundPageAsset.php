<?php

namespace frontend\assets;

class NotFoundPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/not-found.css',
    ];
    public $js = [];
    public $depends = [];

}
