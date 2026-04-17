<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use Yii;
use yii\caching\DbDependency;

class FeaturedProduct extends BaseWidgetFronted
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $language = Yii::$app->language;

        $title = 'Популярні товари';

        $cacheKey = 'featuredProduct_cache_key';
        $dependency = new DbDependency([
            'sql' => 'SELECT MAX(date_updated) FROM product',
        ]);

        $products = Yii::$app->cache->get($cacheKey);

        if ($products === false || !Yii::$app->cache->get($cacheKey . '_db')) {

            $grup_id = 2;
            $limit = 20;

            $products = $this->getWidgetProducts($grup_id, $limit);

            Yii::$app->cache->set($cacheKey, $products, 3600, $dependency);
            Yii::$app->cache->set($cacheKey . '_db', true, 0, $dependency);
        }

        if ($language !== 'uk') {
            $products = $this->translateProductsItem($language, $products);
        }

        $backgroundColor = '#ff000069';
        $borderColor = '#e70f0fcc';

        return $this->render('products-carousel-slide',
            [
                'products' => $products,
                'language' => $language,
                'title' => $title,
                'backgroundColor' => $backgroundColor,
                'borderColor' => $borderColor,
                'backgroundColorClass' => 'featured_product',
            ]);
    }
}