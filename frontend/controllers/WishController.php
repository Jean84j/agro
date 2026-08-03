<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\Product;
use Yii;
use yii\helpers\Url;

class WishController extends BaseFrontendController
{
    public function actionView()
    {
        $language = Yii::$app->language;
        $session = Yii::$app->session;
        $wishList = $session->get('wishList', []);

        $products = Product::find()->where(['id' => $wishList])->all();

        if ($language !== 'uk') {
            $products = $this->translateProduct($products, $language);
        }

        $seo = Settings::seoPageTranslate('wish');

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

        $page_description = $seo->page_description;

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