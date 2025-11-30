<?php

namespace frontend\widgets;

use yii\base\Widget;

class BlockImages extends Widget
{

    public function init()
    {
        parent::init();
    }

    public $files;

    public function run()
    {

        $files = $this->files;

        return $this->render('block-images', ['files' => $files]);
    }
}