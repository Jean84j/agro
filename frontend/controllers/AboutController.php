<?php

namespace frontend\controllers;

use common\models\About;
use common\models\Settings;
use Yii;
use yii\helpers\Url;

class AboutController extends BaseFrontendController
{

    public function actionView()
    {
        $language = Yii::$app->language;
        $model = About::find()->where(['language' => $language])->one();
        $seo = Settings::seoPageTranslate('about');

        Yii::$app->metamaster
            ->setIndexable(false)
            ->setType('website')
            ->setTitle($seo->title)
            ->setDescription(strip_tags($seo->description))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
//            ->setImage('')
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