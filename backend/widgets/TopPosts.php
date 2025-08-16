<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\Posts;
use yii\helpers\ArrayHelper;

class TopPosts extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $uniqueUrls = $this->getPostUniqueUrls();

        ArrayHelper::multisort($uniqueUrls, ['count'], [SORT_DESC]);

        $results = array_slice($uniqueUrls, 0, 10);

        foreach ($results as &$result) {
            $postData = Posts::find()
                ->select([
                    'title AS name',
                    'id',
                    'small AS extra_small',
                ])
                ->where(['slug' => $result['slug']])
                ->asArray()
                ->one();

            if ($postData) {
                $result['name'] = $postData['name'];
                $result['image'] = $postData['extra_small'];
            }
        }

        return $this->render('recent-activity', [
            'results' => $results,
            'catalog' => 'post',
            'catalogImage' => 'posts',
            'titleWidget' => 'ТОП 10 переглянутих статей',
        ]);
    }

}