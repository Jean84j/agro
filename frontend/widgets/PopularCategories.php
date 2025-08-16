<?php

namespace frontend\widgets;

use common\models\shop\Category;
use Yii;
use yii\base\Widget;

class PopularCategories extends Widget  // Популярні Категорії
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $language = Yii::$app->session->get('_language', 'uk');

        $title = 'Популярні Категорії';

        $cat_id = [6, 7, 8, 5, 3, 9];
        $categories = Category::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.parentId',
                'c.slug',
                'c.visibility',
                'c.svg',
                'c.file',
                'c.name AS original_name',
                'IFNULL(ct.name, c.name) AS name'
            ])
            ->leftJoin('categories_translate ct', 'ct.category_id = c.id AND ct.language = :language')
            ->where(['c.id' => $cat_id])
            ->andWhere(['c.visibility' => 1])
            ->addParams([':language' => $language])
            ->all();

        return $this->render('popular-categories',
            [
                'categories' => $categories,
                'language' => $language,
                'title' => $title,
            ]);
    }


}