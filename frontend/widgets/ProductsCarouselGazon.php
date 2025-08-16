<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use Yii;

//use yii\caching\DbDependency;

class ProductsCarouselGazon extends BaseWidgetFronted   // Газонна Трава
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $language = Yii::$app->session->get('_language', 'uk');

//        $title = 'Газонна Трава';
//        $grup_id = 8;
//        $limit = 20;

        $title = 'Насіння соняшника';
        $grup_id = 9;
        $limit = 10;
//        $cacheKey = 'productsCarouselGazon_cache_key';
//        $dependency = new DbDependency([
//            'sql' => 'SELECT MAX(date_updated) FROM product',
//        ]);
//
//        $products = Yii::$app->cache->get($cacheKey);
//
//        if ($products === false || !Yii::$app->cache->get($cacheKey . '_db')) {

        $products = $this->translateProductsCarousel($language, $grup_id, $limit);

        //            Yii::$app->cache->set($cacheKey, $products, 3600, $dependency);
//            Yii::$app->cache->set($cacheKey . '_db', true, 0, $dependency); // Помечаем кэш базы данных как актуальный
//        }

        return $this->render('products-carousel',
            [
                'products' => $products,
                'language' => $language,
                'title' => $title,
            ]);
    }
}
