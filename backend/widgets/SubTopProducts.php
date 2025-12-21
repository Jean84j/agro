<?php

namespace backend\widgets;

use backend\models\ProductsBackend;
use yii\base\Widget;

class SubTopProducts extends Widget
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $monthsAgoTimestamp = strtotime('-5 months');
        $maxViews = 10; // максимум просмотров

        $products = ProductsBackend::find()
            ->alias('p')
            ->select([
                'p.id',
                'p.slug',
                'p.name',
                'p.date_public',
                'p.date_updated',
                'p.views AS count',
                'pi.extra_small AS image',
            ])
            ->leftJoin('product_image pi', 'pi.product_id = p.id')
            ->where(['p.status_id' => 1])
            ->andWhere(['<', 'p.date_public', $monthsAgoTimestamp])
            ->andWhere(['<=', 'p.views', $maxViews])
            ->orderBy([
                'p.views' => SORT_ASC,        // сначала минимальные просмотры
                'p.date_updated' => SORT_ASC, // потом давно не обновлялись
            ])
            ->limit(11)
            ->asArray()
            ->all();

        return $this->render('recent-activity', [
            'results' => $products,
            'catalog' => 'product',
            'catalogImage' => 'product',
            'titleWidget' => '10 товарів з мінімальними переглядами та старим оновленням',
        ]);
    }

}