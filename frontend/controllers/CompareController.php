<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\Product;
use common\models\shop\ProductProperties;
use Yii;

class CompareController extends BaseFrontendController
{
    public function actionView()
    {
        $language = Yii::$app->session->get('_language', 'uk');
        $compareList = Yii::$app->session->get('compareList', []);

        $categories_id = [];
        $products = Product::find()->where(['id' => $compareList])->all();

        foreach ($products as $product) {
            $categories_id[] = $product->category_id;
        }
        $categories_id = array_unique($categories_id);

        $properties = ProductProperties::find()
            ->alias('pp')
            ->select([
                'pp.property_id',
                'COALESCE(pnt.name, pn.name) AS properties',
                'COALESCE(ppt.value, pp.value) AS value',
            ])
            ->leftJoin(
                'properties_name pn',
                'pn.id = pp.property_id'
            )
            ->leftJoin(
                'properties_name_translate pnt',
                'pnt.name_id = pn.id AND pnt.language = :language'
            )
            ->leftJoin(
                'product_properties_translate ppt',
                'ppt.product_properties_id = pp.id AND ppt.language = :language'
            )
            ->where(['pp.category_id' => $categories_id])
            ->asArray()
            ->orderBy(['pn.sort' => SORT_ASC])
            ->addParams([':language' => $language])
            ->all();

        $uniqueArray = [];
        $seenProperties = [];

        foreach ($properties as $item) {
            if (!in_array($item['properties'], $seenProperties)) {
                $seenProperties[] = $item['properties'];
                $uniqueArray[] = $item;
            }
        }

        $products = $this->translateProduct($products, $language);

        $seo = Settings::seoPageTranslate('compare');
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
                'products' => $products,
                'properties' => $uniqueArray,
                'page_description' => $seo->page_description,
            ]);
    }

    public function actionAddToCompare()
    {
        $id = Yii::$app->request->post('id');

        $session = Yii::$app->session;

        // Инициализируем массив сравнения в сессии, если его еще нет
        if (!$session->has('compareList')) {
            $session->set('compareList', []);
        }

        $compareList = $session->get('compareList');

        // Добавляем товар в список сравнения, если его там еще нет
        if (!in_array($id, $compareList)) {
            $compareList[] = $id;
            $session->set('compareList', $compareList);
        }

        return $this->asJson(
            [
                'success' => true,
                'compareCount' => count($compareList),
            ]);
    }

    public function actionDeleteFromCompare()
    {
        $id = Yii::$app->request->post('id');
        $language = Yii::$app->session->get('_language', 'uk');
        $session = Yii::$app->session;
        $compareList = $session->get('compareList', []);

        $index = array_search($id, $compareList);

        if ($index !== false) {
            unset($compareList[$index]);
            $session->set('compareList', $compareList);

            $categories_id = [];
            $products = Product::find()->where(['id' => $compareList])->all();

            foreach ($products as $product) {
                $categories_id[] = $product->category_id;
            }
            $categories_id = array_unique($categories_id);
            $properties = ProductProperties::find()
                ->alias('pp')
                ->select([
                    'pp.property_id',
                    'COALESCE(pnt.name, pn.name) AS properties',
                    'COALESCE(ppt.value, pp.value) AS value',
                ])
                ->leftJoin(
                    'properties_name pn',
                    'pn.id = pp.property_id'
                )
                ->leftJoin(
                    'properties_name_translate pnt',
                    'pnt.name_id = pn.id AND pnt.language = :language'
                )
                ->leftJoin(
                    'product_properties_translate ppt',
                    'ppt.product_properties_id = pp.id AND ppt.language = :language'
                )
                ->where(['pp.category_id' => $categories_id])
                ->asArray()
                ->orderBy(['pn.sort' => SORT_ASC])
                ->addParams([':language' => $language])
                ->all();

            $uniqueArray = [];
            $seenProperties = [];

            foreach ($properties as $item) {
                if (!in_array($item['properties'], $seenProperties)) {
                    $seenProperties[] = $item['properties'];
                    $uniqueArray[] = $item;
                }
            }

            $products = $this->translateProduct($products, $language);
            return $this->asJson([
                'success' => true,
                'compareListHtml' => $this->renderPartial('_compareList',
                    [
                        'compareList' => $compareList,
                        'products' => $products,
                        'properties' => $uniqueArray,
                    ]),
                'compareCount' => count($compareList), // Отправляем количество продуктов в сравнении
            ]);
        }

        // Если товар не найден, отправляем JSON-ответ с ошибкой
        return $this->asJson(['success' => false]);
    }

}