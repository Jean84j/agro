<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;

class TopProductsBig extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $package = 'BIG';

        $resultProduct = $this->getOrdersProducts($package);

        return $this->render('recent-activity', [
            'results' => $resultProduct,
            'catalog' => 'product',
            'catalogImage' => 'product',
            'titleWidget' => 'ТОП 10 фермерська упаковка',
            'icon' => '<i class="fas fa-cart-arrow-down"></i>',
        ]);
    }
}