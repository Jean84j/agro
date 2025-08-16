<?php

namespace frontend\widgets;

use common\models\shop\Brand;
use Yii;
use yii\base\Widget;
use yii\caching\DbDependency;

class BlockBrands extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $cacheKey = 'brands_cache_key';
        $brands = Yii::$app->cache->get($cacheKey);

        if ($brands === false) {
            $brands = Brand::find()->all();

            Yii::$app->cache->set($cacheKey, $brands, 3600, new DbDependency([
                'sql' => 'SELECT COUNT(*) FROM brand',
            ]));
        }
        return $this->render('block-brands', ['brands' => $brands]);
    }
}