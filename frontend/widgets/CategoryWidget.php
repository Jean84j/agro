<?php


namespace frontend\widgets;


use common\models\shop\Category;
use yii\base\Widget;

class CategoryWidget extends Widget
{


    public function run(){

        $categories = Category::find()->select('id, parentId, slug, file, name, visibility')
            ->with(['parents', 'parent', 'products'])
            ->where(['is', 'parentId', new \yii\db\Expression('null')])
//            ->orderBy('name ASC')
//            ->asArray()
            ->all();
        return $this->render('category-widget', ['categories' => $categories]);

    }

}