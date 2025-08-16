<?php

namespace backend\widgets;

use common\models\Posts;
use common\models\shop\Brand;
use common\models\shop\Product;
use common\models\shop\Tag;
use kartik\base\Widget;
use Yii;

class TasksAdmin extends Widget
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $tasks[] = $this->countProducts();
        $tasks[] = $this->countTags();
        $tasks[] = $this->countPosts();
        $tasks[] = $this->countBrands();

        return $this->render('tasks-admin', ['tasks' => $tasks]);
    }

    /**
     * Количество продуктов которых нужно добавить
     */
    protected function countProducts()
    {
        $addCountProducts = 1000;
        $countsProduct = Product::find()->count();
        $addProducts = [
            'svg' => 'products',
            'title' => 'Добавить товар ' . $addCountProducts . ' шт.',
            'descr' => 'Осталось ' . '<span style="font-weight: bold;">' . $addCountProducts - $countsProduct . '</span>' . ' шт.',
        ];
        return $addProducts;
    }

    /**
     * Теги без описания
     */
    protected function countTags()
    {
        $countsTag = Tag::find()->count();
        $countsNotDescr = Tag::find()->where(['description' => ''])->orWhere(['description' => null])->count();
        $addTagDescr = [
            'svg' => 'tags',
            'title' => 'Добавить описания тегам',
            'descr' => 'Осталось ' . '<span style="font-weight: bold;">' . $countsNotDescr . '</span>' . ' из ' . '<span style="font-weight: bold;">' . $countsTag . '</span>',
        ];
        return $addTagDescr;
    }

    /**
     * Количество статей которые нужно добавить
     */
    protected function countPosts()
    {
        $currentTimestamp = Yii::$app->formatter->asTimestamp('now');
        $timeStamp = Posts::find()
            ->select('date_public')
            ->orderBy(['date_public' => SORT_DESC])
            ->scalar();

        $secondsDifference = abs($currentTimestamp - $timeStamp);
        $weeks = floor($secondsDifference / (7 * 24 * 60 * 60));

        $formattedDate = Yii::$app->formatter->asDate($timeStamp, 'short');

        $addPostDescr = [
            'svg' => 'posts',
            'title' => 'Добавлять статью каждую неделю ',
            'descr' => 'C ' . '<span style="font-weight: bold;">' . $formattedDate . '</span>' . ' добавить ' . '<span style="font-weight: bold;">' . $weeks . '</span>' . ' статьи',

        ];
        return $addPostDescr;
    }

    /**
     * Теги без описания
     */
    protected function countBrands()
    {
        $countsBrand = Brand::find()->count();
        $countsNotDescr = Brand::find()
            ->where(['description' => ''])
            ->orWhere(['description' => null])
            ->count();
        $addBrandDescr = [
            'svg' => 'tags',
            'title' => 'Добавить описания брендам',
            'descr' => 'Осталось ' . '<span style="font-weight: bold;">' . $countsNotDescr . '</span>' . ' из ' . '<span style="font-weight: bold;">' . $countsBrand . '</span>',
        ];
        return $addBrandDescr;
    }
}
