<?php

namespace frontend\widgets;

use yii\base\Widget;

class BlockImages extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $links = [
           '/images/special/news.png',
           '/images/special/stock.jpg',
           '/images/special/discounts.jpg',
           '/images/special/sales.jpg',

        ];

        return $this->render('block-images', ['links' => $links]);
    }
}