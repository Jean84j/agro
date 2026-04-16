<?php

namespace frontend\controllers;

use common\models\Delivery;
use common\models\Settings;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class DeliveryController extends Controller
{

    public function actionView()
    {
        $language = Yii::$app->language;
        $model = Delivery::find()->where(['language' => $language])->one();

        $seo = Settings::seoPageTranslate('delivery');
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
        $ukUrl = $url . '/delivery';
        $ruUrl = $url . '/ru/delivery';

        return [
            'ukUrl' => $ukUrl,
            'ruUrl' => $ruUrl,
        ];
    }

}