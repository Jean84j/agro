<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Login backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        "css/robot-login.css",
    ];
    public $js = [

         'js/robot-login.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
