<?php

namespace frontend\controllers;

use common\models\About;
use common\models\Settings;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class AboutController extends Controller
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
        $alternateUrls = $this->getAlernateUrl();
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

    protected function getAlernateUrl(): array
    {
        $url = Yii::$app->request->hostInfo;
        $ukUrl = $url . '/about';
        $ruUrl = $url . '/ru/about';

        return [
            'ukUrl' => $ukUrl,
            'ruUrl' => $ruUrl,
        ];
    }

}