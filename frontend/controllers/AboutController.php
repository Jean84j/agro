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
        $type = 'website';
        $url = Url::canonical();
        $title = $seo->title;
        $description = $seo->description;
        $image = '';
        $keywords = '';
        $alternateUrls = $this->getAlternateUrl();
        Settings::setMetamaster($type, $title, $description, $image, $keywords, $url, $alternateUrls);

        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'noindex, follow'
        ]);

        return $this->render('view',
            [
                'model' => $model,
                'page_description' => $seo->page_description,
            ]);
    }

}