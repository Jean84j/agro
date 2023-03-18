<?php


namespace frontend\widgets;


use common\models\shop\Product;
use yii\base\Widget;

class ColumnsSpecialOffers extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
//      $products = Product::find()->with('label')->limit(3)->all();
        $products = Product::find()->with('label')->limit(3)->where(['category_id' => 6])->all();
        return $this->render('columns-special-offers', ['products' => $products]);
    }


}