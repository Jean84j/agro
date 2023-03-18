<?php


namespace frontend\widgets;


use common\models\shop\Product;
use yii\base\Widget;

class ColumnsTopRated extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
//      $products = Product::find()->with('label')->orderBy('id DESC')->limit(3)->all();
        $products = Product::find()->with('label')->limit(3)->where(['category_id' => 5])->all();

//debug($products);
//die;

        return $this->render('columns-top-rated', ['products' => $products]);
    }


}