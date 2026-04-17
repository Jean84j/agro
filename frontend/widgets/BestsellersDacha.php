<?php


namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use Yii;

class BestsellersDacha extends BaseWidgetFronted
{

    public function init()
    {
        parent::init();

    }

    public function run() {

        $language = Yii::$app->language;
        $title = 'Товари для Дачі';

        $grup_id = 7;
        $limit = 7;

        $products = $this->getWidgetProducts($grup_id, $limit);

        if ($language !== 'uk') {
            $products = $this->translateProductsItem($language, $products);
        }

        $backgroundColor = '#94d944c2';
        $borderColor = '#57ab07cc';

        return $this->render('bestsellers',
            [
                'products' => $products,
                'title' => $title,
                'language' => $language,
                'backgroundColor' => $backgroundColor,
                'borderColor' => $borderColor,
                'backgroundColorClass' => 'bestsellers_dacha',
            ]);
    }


}