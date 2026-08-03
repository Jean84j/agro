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

        Settings::setMetamaster([
            'type' => 'website',
            'title' => $seo->title,
            'description' => $seo->description,
            'image' => '',
            'keywords' => '',
            'url' => Url::canonical(),
            'alternateUrls' => $this->getAlternateUrl(),
            'indexable' => false,
        ]);

        return $this->render('view',
            [
                'model' => $model,
                'page_description' => $seo->page_description,
            ]);

    }

}