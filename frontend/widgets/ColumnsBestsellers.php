<?php


namespace frontend\widgets;


use common\models\shop\Product;
use yii\base\Widget;

class ColumnsBestsellers extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $products = Product::find()->with('label')->limit(3)->all();

        return $this->render('columns-bestsellers', ['products' => $products]);
    }


}