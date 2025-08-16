<?php

namespace frontend\controllers;

use common\models\shop\Product;
use yii\web\Controller;
use Yii;

class QuickviewController extends Controller
{
    public function actionQuickview($id)
    {
        $language = Yii::$app->session->get('_language', 'uk');
        $product = Product::find()
            ->where(['id' => $id])
            ->one();

        if ($language !== 'uk') {
            $this->getProductTranslation($product, $language);
        }

        return $this->renderPartial('quickview', [
            'language' => $language,
            'product' => $product,
        ]);
    }

    protected function getProductTranslation($product, $language)
    {
        if ($product) {
            $translationProd = $product->getTranslation($language)->one();
            if ($translationProd) {
                if ($translationProd->name) {
                    $product->name = $translationProd->name;
                }
                if ($translationProd->description) {
                    $product->description = $translationProd->description;
                }
                if ($translationProd->short_description) {
                    $product->short_description = $translationProd->short_description;
                }
                if ($translationProd->footer_description) {
                    $product->footer_description = $translationProd->footer_description;
                }
                if ($translationProd->seo_title) {
                    $product->seo_title = $translationProd->seo_title;
                }
                if ($translationProd->seo_description) {
                    $product->seo_description = $translationProd->seo_description;
                }
                if ($translationProd->keywords) {
                    $product->keywords = $translationProd->keywords;
                }
            }
            $translationCat = $product->category->getTranslation($language)->one();
            if ($translationCat) {
                if ($translationCat->name) {
                    $product->category->name = $translationCat->name;
                }
                if ($translationCat->prefix) {
                    $product->category->prefix = $translationCat->prefix;
                }
            }
            if ($product->category->parent) {
                $translationCatParent = $product->category->parent->getTranslation($language)->one();
                if ($translationCatParent) {
                    if ($translationCatParent->name) {
                        $product->category->parent->name = $translationCatParent->name;
                    }
                }
            }
        }
    }

}