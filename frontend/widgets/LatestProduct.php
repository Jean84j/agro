<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use Yii;

class LatestProduct extends BaseWidgetFronted
{
    public function init()
    {
        parent::init();
    }
    public $products;

    public function run()
    {
        $language =Yii::$app->session->get('_language');

        $title = 'Може зацікавити';

        $products = $this->products;

        return $this->render('latest-product',
            [
                'products' => $products,
                'language' => $language,
                'title' => $title,
            ]);
    }

}