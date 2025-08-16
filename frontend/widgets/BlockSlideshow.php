<?php

namespace frontend\widgets;

use common\models\Slider;
use Yii;
use yii\base\Widget;
use yii\caching\DbDependency;

class BlockSlideshow extends Widget  // Головний слайдер
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
//        $cacheKey = 'sliders_cache_key';
//        $sliders = Yii::$app->cache->get($cacheKey);
//
//        if ($sliders === false) {
//            $sliders = Slider::find()
//                ->where(['visible' => 1])
//                ->all();
//
//            Yii::$app->cache->set($cacheKey, $sliders, 3600, new DbDependency([
//                'sql' => 'SELECT COUNT(*) FROM slider',
//            ]));
//        }

        $sliders = Slider::find()
            ->where(['visible' => 1])
            ->all();

        return $this->render('block-slideshow', ['slides' => $sliders]);
    }
}