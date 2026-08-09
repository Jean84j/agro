<?php

namespace frontend\assets;

use yii\web\AssetBundle;

abstract class BaseAssetBundle extends AssetBundle
{
    public function init()
    {
        parent::init();

        if (defined('PROJECT_VERSION')) {
            $versioner = static fn($file) => $file . '?v=' . PROJECT_VERSION;
            $this->css = array_map($versioner, $this->css);
            $this->js = array_map($versioner, $this->js);
        }
    }
}
