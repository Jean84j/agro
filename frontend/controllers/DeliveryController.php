<?php

namespace frontend\controllers;

use common\models\Delivery;
use common\models\Settings;
use Yii;
use yii\web\Controller;

class DeliveryController extends Controller
{

    public function actionView()
    {
        $language = Yii::$app->language;
        $model = Delivery::find()->where(['language' => $language])->one();

        $seo = Settings::seoPageTranslate('delivery');
        $type = 'website';
        $title = $seo->title;
        $description = $seo->description;
        $image = '';
        $keywords = '';
        Settings::setMetamaster($type, $title, $description, $image, $keywords);

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