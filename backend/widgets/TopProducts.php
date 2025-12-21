<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use backend\models\ProductsBackend;

class TopProducts extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $productsData = ProductsBackend::find()
            ->alias('p')
            ->select([
                'p.name',
                'p.id',
                'p.slug',
                'p.views AS count',
                'pi.extra_small AS image',
            ])
            ->leftJoin('product_image pi', 'pi.product_id = p.id')
            ->orderBy(['p.views' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        return $this->render('recent-activity', [
            'results' => $productsData,
            'catalog' => 'product',
            'catalogImage' => 'product',
            'titleWidget' => 'ТОП 10 переглянутих товарів',
        ]);
    }
}