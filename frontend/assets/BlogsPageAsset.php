<?php

namespace frontend\assets;

class BlogsPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/block-sidebar.css',
        'css/widget-search.css',
    ];
    public $js = [];
    public $depends = [];

}
