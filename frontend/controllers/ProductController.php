<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\shop\Product;

class ProductController extends Controller
{
    public function actionView($slug): string
    {
        $product = Product::find()->with('category.parent')->where(['slug' => $slug])->one(); //all products

        return $this->render('_index', [
            'product' => $product,
            'isset_to_cart' => $product->getIssetToCart($product->id)
        ]);
    }

}
