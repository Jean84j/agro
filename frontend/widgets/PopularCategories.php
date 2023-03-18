<?php


namespace frontend\widgets;


use common\models\shop\Category;
use yii\base\Widget;

class PopularCategories extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $categories = Category::find()->limit(6)->all();

        return $this->render('popular-categories', ['categories' => $categories]);
    }


}