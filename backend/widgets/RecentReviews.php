<?php

namespace backend\widgets;

use common\models\shop\Review;
use yii\base\Widget;

class RecentReviews extends Widget
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $reviews = Review::find()
            ->alias('r')
            ->select([
                'r.id',
                'r.created_at',
                'r.name AS fio',
                'r.message',
                'r.rating',
                'r.product_id',
                'p.slug',
                'p.name',
                '(SELECT pi.extra_small FROM product_image pi 
                 WHERE pi.product_id = p.id 
                 ORDER BY pi.priority ASC LIMIT 1) AS image',
            ])
            ->leftJoin('product p', 'p.id = r.product_id')
            ->orderBy(['r.id' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        return $this->render('recent-reviews', [
            'reviews' => $reviews,
            'catalog' => 'product',
            'catalogImg' => 'product',
            'title' => 'Останні відгуки Про товари',
        ]);
    }
}

