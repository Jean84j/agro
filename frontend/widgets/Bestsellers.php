<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use Yii;

class Bestsellers extends BaseWidgetFronted
{

    public function init()
    {
        parent::init();

    }

    public function run() {

        $language = Yii::$app->language;
        $title = 'Товари для Фермера';
        $grup_id = 1;
        $limit = 7;

        $products = $this->getWidgetProducts($grup_id, $limit);

        if ($language !== 'uk') {
            $products = $this->translateProductsItem($language, $products);
        }

        $backgroundColor = '#fda20396';
        $borderColor = '#a17e01cc';

        return $this->render('bestsellers',
            [
                'products' => $products,
                'title' => $title,
                'language' => $language,
                'backgroundColor' => $backgroundColor,
                'borderColor' => $borderColor,
                'backgroundColorClass' => 'bestsellers',
            ]);
    }


}