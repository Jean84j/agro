<?php


namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use common\models\shop\Product;
use common\models\shop\ProductGrup;
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

        $products_grup = ProductGrup::find()
            ->select('product_id')
            ->where(['grup_id' => 7])
            ->column();

        $products = Product::find()
            ->select([
                'id',
                'name',
                'slug',
                'price',
                'old_price',
                'status_id',
                'label_id',
                'currency',
                'category_id',
            ])
            ->with('label')
            ->where(['id' => $products_grup])
            ->limit(7)
            ->all();

        $products = $this->translateProductsItem($language, $products);

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