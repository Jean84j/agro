<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use common\models\shop\Product;
use Yii;

class ViewProduct extends BaseWidgetFronted
{

    public function init()
    {
        parent::init();

    }

    public $id;

    public function run()
    {
        $language = Yii::$app->session->get('_language');

        $title = 'Ви переглядали';

        if (isset($this->id)) {
            $id = $this->id;
            $product = Product::findOne($id);
            $viewedProducts = Yii::$app->session->get('viewedProducts', []);
            array_unshift($viewedProducts, $product->id);
            $viewedProducts = array_unique($viewedProducts);
            $viewedProducts = array_slice($viewedProducts, 0, 10); // Ограничение на количество просмотренных товаров
            Yii::$app->session->set('viewedProducts', $viewedProducts);
        } else {
            $viewedProducts = Yii::$app->session->get('viewedProducts', []);
            $viewedProducts = array_slice($viewedProducts, 0, 10); // Ограничение на количество просмотренных товаров
        }
        $viewedProductsData = Product::find()
            ->select([
                'id',
                'name',
                'slug',
                'price',
                'old_price',
                'status_id',
                'label_id',
                'currency',
                'package',
                'category_id',
            ])
            ->where(['id' => $viewedProducts])
            ->all();

        $viewedProductsData = $this->translateProductsItem($language, $viewedProductsData);

        return $this->render('products-carousel-slide',
            [
                'products' => $viewedProductsData,
                'language' => $language,
                'title' => $title,
            ]);
    }
}

