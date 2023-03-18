<?php


namespace frontend\widgets;


use common\models\shop\Product;
use yii\base\Widget;

class FeaturedProduct extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $products = Product::find()->limit(20)->all();

        return $this->render('featured-product', ['products' => $products]);
    }


}