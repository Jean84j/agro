<?php

namespace frontend\assets;

class SpecialPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/view-options.css',
    ];
    public $js = [];
    public $depends = [];

}
