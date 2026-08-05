<?php

namespace frontend\controllers;

use common\models\Delivery;
use common\models\Settings;
use Yii;
use yii\helpers\Url;

class DeliveryController extends BaseFrontendController
{

    public function actionView()
    {
        $language = Yii::$app->language;
        $model = Delivery::find()->where(['language' => $language])->one();

        $seo = Settings::seoPageTranslate('delivery');

        Yii::$app->metamaster
            ->setIndexable(false)
            ->setType('website')
            ->setTitle($seo->title)
            ->setDescription(strip_tags($seo->description))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
            ->setImage('/images/og_img/delivery_page.webp')
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

        return $this->render('view',
            [
                'model' => $model,
                'page_description' => $seo->page_description,
            ]);

    }

}