<?php

namespace frontend\assets;

class PostPageAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/typography.css',
        'css/post-page.min.css',
    ];
    public $js = [

        YII_ENV_DEV ? 'js/post-page.js' : 'js/post-page.min.js',
    ];
    public $depends = [];

}
