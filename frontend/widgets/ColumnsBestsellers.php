<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use Yii;
use yii\helpers\Url;

class ColumnsBestsellers extends BaseWidgetFronted  //  Інсектициди
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $language = Yii::$app->language;
        $title = 'Інсектициди';
        $url = Url::to(['product-list/insektitsidi']);

        $grup_id = 6;
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