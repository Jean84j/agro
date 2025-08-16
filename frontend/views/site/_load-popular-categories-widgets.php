<?php use frontend\widgets\PopularCategories;

if (!Yii::$app->devicedetect->isMobile()) echo PopularCategories::widget(); ?>
