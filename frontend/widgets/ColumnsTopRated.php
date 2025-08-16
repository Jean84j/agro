<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use Yii;
use yii\helpers\Url;

class ColumnsTopRated extends BaseWidgetFronted   //  Гербіциди
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $language = Yii::$app->session->get('_language', 'uk');
        $title = 'Гербіциди';
        $url = Url::to(['product-list/gerbitsidi']);

        $grup_id = 4;
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