<?php

namespace backend\widgets;

use common\models\shop\Brand;
use yii\base\Widget;

class BrandOrders extends Widget
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {

        /**
         * $brand->getIncomeOrderBrand($brand->id)
         * $brand->getProductOrderBrand($brand->id)
         * $brand->getColorBrand($i)
         */

        $brands = Brand::find()->all();

        $carts = [];
        $i = 0;
        foreach ($brands as $brand) {
            $productOrderBrand = $brand->getProductOrderBrand($brand->id);
            $incomeOrderBrand = $brand->getIncomeOrderBrand($brand->id);
            if ($productOrderBrand != 0 && $incomeOrderBrand != 0) {
                $carts[] = [
                    "label" => $brand->name,
                    "value" => $incomeOrderBrand,
                    "orders" => $productOrderBrand,
                ];
            }
        }
        usort($carts, function($a, $b) {
            return floatval($b['value']) - floatval($a['value']);
        });
        $carts = array_slice($carts, 0, 8);
        foreach ($carts as &$cart){
            $cart['color'] = $brand->getColorBrand($i);
            $i++;
        }
        unset($cart);


        return $this->render('brand-orders', ['brands' => $carts, 'carts' => json_encode($carts)]);
    }

}

