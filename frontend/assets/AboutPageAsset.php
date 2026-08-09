<?php

namespace frontend\assets;

class AboutPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/about.css',
        'css/typography.css',
    ];
    public $js = [];
    public $depends = [];

}
