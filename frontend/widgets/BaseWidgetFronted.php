<?php

namespace app\widgets;

use common\models\shop\Product;
use common\models\shop\ProductGrup;
use yii\base\Widget;

class BaseWidgetFronted extends Widget
{


    /**
     *
     */
    protected function translateProductsItem($language, $products)
    {

        if ($language !== 'uk') {
            foreach ($products as $product) {
                if ($product) {
                    $translationProd = $product->getTranslation($language)->one();
                    if ($translationProd) {
                        if ($translationProd->name) {
                            $product->name = $translationProd->name;
                        }
                    }
                    $translationCat = $product->category->getTranslation($language)->one();
                    if ($translationCat) {
                        if ($translationCat->name) {
                            $product->category->name = $translationCat->name;
                        }
                        if ($translationCat->prefix) {
                            $product->category->prefix = $translationCat->prefix;
                        }
                    }
                }
            }
        }
        return $products;
    }

    /**
     *
     */
    protected function translateProductsCarousel($language, $grup_id, $limit)
    {
        return Product::find()
            ->alias('p')
            ->select([
                'p.id',
                'IFNULL(pt.name, p.name) AS name',
                'p.slug',
                'p.price',
                'p.old_price',
                'p.status_id',
                'p.label_id',
                'p.currency',
            ])
            ->leftJoin(
                'products_translate pt',
                'pt.product_id = p.id AND pt.language = :language'
            )
            ->where(['p.id' => ProductGrup::find()->select('product_id')->where(['grup_id' => $grup_id])])
            ->with('label')
            ->limit($limit)
            ->addParams([':language' => $language])
            ->all();
    }

}
