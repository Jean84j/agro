<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;

class TopProductsSmall extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $package = 'SMALL';

        $resultProduct = $this->getOrdersProducts($package);

        return $this->render('recent-activity', [
            'results' => $resultProduct,
            'catalog' => 'product',
            'catalogImage' => 'product',
            'titleWidget' => 'ТОП 10 дрібна упаковка',
            'icon' => '<i class="fas fa-cart-arrow-down"></i>',
        ]);
    }
}