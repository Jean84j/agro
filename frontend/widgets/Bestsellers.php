<?php


namespace frontend\widgets;


use common\models\shop\Product;
use yii\base\Widget;

class Bestsellers extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $products = Product::find()->with('label')->limit(6)->all();

        return $this->render('bestsellers', ['products' => $products]);
    }


}