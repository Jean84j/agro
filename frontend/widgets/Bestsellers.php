<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use common\models\shop\Product;
use common\models\shop\ProductGrup;
use Yii;

class Bestsellers extends BaseWidgetFronted
{

    public function init()
    {
        parent::init();

    }

    public function run() {

        $language =Yii::$app->session->get('_language');
        $title = 'Товари для Фермера';

        $products_grup = ProductGrup::find()
            ->select('product_id')
            ->where(['grup_id' => 1])            //  Перша_Группа_Тест
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

        return $this->render('bestsellers',
            [
                'products' => $products,
                'title' => $title,
                'language' => $language,
            ]);
    }


}