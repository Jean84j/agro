<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use Yii;
use yii\helpers\Url;

class ColumnsSpecialOffers extends BaseWidgetFronted  // Фунгіциди
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $language = Yii::$app->session->get('_language', 'uk');
        $title = 'Фунгіциди';
        $url = Url::to(['product-list/fungitsidi']);

        $grup_id = 5;
        $limit = 3;

        $products = $this->translateProductsCarousel($language, $grup_id, $limit);

        return $this->render('product-columns',
            [
                'products' => $products,
                'title' => $title,
                'url' => $url,
                'language' => $language,
            ]);
    }

}