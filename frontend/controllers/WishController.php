<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\Product;
use Yii;

class WishController extends BaseFrontendController
{
    public function actionView()
    {
        $language = Yii::$app->session->get('_language');
        $session = Yii::$app->session;
        $wishList = $session->get('wishList', []);

        $products = Product::find()->where(['id' => $wishList])->all();

        $products = $this->translateProduct($products, $language);

        $seo = Settings::seoPageTranslate('wish');
        $type = 'website';
        $title = $seo->title;
        $description = $seo->description;
        $image = '';
        $keywords = '';
        Settings::setMetamaster($type, $title, $description, $image, $keywords);

        $page_description = $seo->page_description;

        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'noindex, follow'
        ]);

        return $this->render('view',
            [
                'products' => $products,
                'page_description' => $page_description,
            ]);
    }

    public function actionAddToWish()
    {
        $id = Yii::$app->request->post('id');

        $session = Yii::$app->session;

        // Инициализируем массив сравнения в сессии, если его еще нет
        if (!$session->has('wishList')) {
            $session->set('wishList', []);
        }

        $wishList = $session->get('wishList');

        // Добавляем товар в список сравнения, если его там еще нет
        if (!in_array($id, $wishList)) {
            $wishList[] = $id;
            $session->set('wishList', $wishList);
        }

        return $this->asJson(
            [
                'success' => true,
                'wishCount' => count($wishList),
            ]);
    }

    public function actionDeleteFromWish()
    {
        $id = Yii::$app->request->post('id');

        $session = Yii::$app->session;
        $wishList = $session->get('wishList', []);

        $index = array_search($id, $wishList);

        if ($index !== false) {
            unset($wishList[$index]);
            $session->set('wishList', $wishList);

            $products = Product::find()->where(['id' => $wishList])->all();

            return $this->asJson([
                'success' => true,
                'wishListHtml' => $this->renderPartial('_wishlist',
                    [
                        'wishList' => $wishList,
                        'products' => $products,
                    ]),
                'wishCount' => count($wishList),
            ]);
        }

        // Если товар не найден, отправляем JSON-ответ с ошибкой
        return $this->asJson(['success' => false]);
    }

}