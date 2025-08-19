<?php

namespace frontend\widgets;

use common\models\shop\Category;
use Yii;
use yii\base\Widget;
use yii\caching\DbDependency;
use yii\db\Expression;

class CategoryWidget extends Widget
{
    public function run()
    {
        $language = Yii::$app->language;
        $cacheKey = 'category_cache_key';
        $dependency = new DbDependency([
            'sql' => 'SELECT MAX(date_updated) FROM category',
        ]);

        $categories = Yii::$app->cache->get($cacheKey);

        if ($categories === false || !Yii::$app->cache->get($cacheKey . '_db')) {
            $categories = Category::find()->select('id, parentId, slug, file, name, visibility, svg')
                ->with(['parents', 'parent', 'products'])
                ->where(['is', 'parentId', new Expression('null')])
                ->andWhere(['visibility' => 1])
                ->all();

            Yii::$app->cache->set($cacheKey, $categories, 3600, $dependency);
            Yii::$app->cache->set($cacheKey . '_db', true, 0, $dependency);
        }

        if ($language !== 'uk') {
            foreach ($categories as $category) {
                $translationCat = $category->getTranslation($language)->one();
                if ($translationCat) {
                    if ($translationCat->name) {
                        $category->name = $translationCat->name;
                    }
                    if ($translationCat->description) {
                        $category->description = $translationCat->description;
                    }
                }
                if ($category->parents){
                    foreach ($category->parents as $parent) {
                        if ($parent !== null) {
                            $translationCatParent = $parent->getTranslation($language)->one();
                            if ($translationCatParent) {
                                $parent->name = $translationCatParent->name;
                            }
                            if ($parent->products) {
                                $i = 0;
                                foreach ($parent->products as $product) {
                                    if ($i <= 5) {
                                        if ($product) {
                                            $translationProduct = $product->getTranslation($language)->one();
                                            if ($translationProduct) {
                                                $product->name = $translationProduct->name;
                                            }
                                        }
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }else{
                    if ($category->products){
                        $i = 0;
                        foreach ($category->products as $product) {
                            if ($i <= 5) {
                                if ($product) {
                                    $translationProduct = $product->getTranslation($language)->one();
                                    if ($translationProduct) {
                                        $product->name = $translationProduct->name;
                                    }
                                }
                            }
                            $i++;
                        }
                    }
                }
            }
        }

        return $this->render('category-widget', ['categories' => $categories]);

    }
}