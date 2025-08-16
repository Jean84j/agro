<?php

namespace backend\widgets;

use common\models\PostsReview;
use yii\base\Widget;

class PostReviews extends Widget
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $reviews = PostsReview::find()
            ->alias('pr')
            ->select([
                'pr.id',
                'pr.created_at',
                'pr.name AS fio',
                'pr.message',
                'pr.rating',
                'pr.post_id',
                'p.slug',
                'p.small AS image',
                'p.title AS name',
            ])
            ->leftJoin('posts p', 'p.id = pr.post_id')
            ->orderBy(['pr.id' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        return $this->render('recent-reviews', [
            'reviews' => $reviews,
            'catalog' => 'post',
            'catalogImg' => 'posts',
            'title' => 'Останні відгуки Про статті',
        ]);
    }
}