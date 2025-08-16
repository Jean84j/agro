<?php


namespace console\controllers;


use common\models\shop\Product;

class ProductSkuController extends \yii\console\Controller
{


    /**
     * Добавление SKU
     */
    public function actionAddSku()
    {
        $i = 1;
        $products = Product::find()->all();
        foreach ($products as $product){
            $product->sku = 'PRO-100' . $product->id;

            if ($product->save(false)) {
                echo "\t" . $i . " Артикул добавлен \n";
                $i++;
            }

        }


    }

}