<?php

namespace frontend\controllers;

use yii\web\NotFoundHttpException;
use common\models\shop\Product;
use yii\web\Response;
use Yii;

class CartController extends BaseFrontendController
{
    public function actionCartView($id, $qty = 1)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cart = Yii::$app->cart;

        $model = Product::find()
            ->select(['id', 'price', 'name', 'slug', 'currency'])
            ->where(['id' => $id])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        if ($model->getIssetToCart($model->id)) {
            $qty = 0;
        }

        $cart->put($model, $qty);

        $qtyCart = $cart->getCount();
        $orders = $cart->getPositions();
        $totalSumm = $cart->getCost();
        $minimumOrderAmount = $this->getMinimumOrderAmount();

        return [
            'qty' => $qtyCart,

            'html' => $this->renderPartial('cart-view', [
                'orders' => $orders,
                'total_summ' => $totalSumm,
                'qty_cart' => $qtyCart,
                'minimumOrderAmount' => $minimumOrderAmount,
                'urls' => $this->getUrls(),
            ]),
        ];
    }

    public function actionCartViewAll()
    {
        if (0 == Yii::$app->cart->getCost()) {
            $modalCart = 'cart-empty';
        } else {
            $modalCart = 'cart-view';
        }

        return $this->renderPartial($modalCart, [
            'orders' => Yii::$app->cart->getPositions(),
            'total_summ' => Yii::$app->cart->getCost(),
            'qty_cart' => Yii::$app->cart->getCount(),
            'minimumOrderAmount' => $this->getMinimumOrderAmount(),
            'urls' => $this->getUrls(),
        ]);
    }

    public function actionRemove($id)
    {
        $view = '_cart-view';
        $product = Product::findOne($id);
        if ($product) {
            Yii::$app->cart->remove($product);
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if (Yii::$app->cart->getCount() < 1) {
                    $view = 'cart-empty';
                }

                $orders = Yii::$app->cart->getPositions();
                $totalSumm = Yii::$app->cart->getCost();
                $qtyCart = Yii::$app->cart->getCount();
                $minimumOrderAmount = $this->getMinimumOrderAmount();

                return [
                    'qty' => $qtyCart,

                    'html' => $this->renderPartial($view, [
                        'orders' => $orders,
                        'total_summ' => $totalSumm,
                        'qty_cart' => $qtyCart,
                        'minimumOrderAmount' => $minimumOrderAmount,
                        'urls' => $this->getUrls(),
                    ]),

                    'order' => $this->renderPartial('/order/_totals-products', [
                        'orders' => $orders,
                        'total_summ' => $totalSumm,
                        'minimumOrderAmount' => $minimumOrderAmount,
                    ]),
                ];
            }
        }
        return null;
    }


    public function actionUpdate($id, $qty = null)
    {
        $product = Product::findOne($id);
        Yii::$app->cart->update($product, $qty);
        Yii::$app->response->format = Response::FORMAT_JSON;

        $orders = Yii::$app->cart->getPositions();
        $totalSumm = Yii::$app->cart->getCost();
        $qtyCart = Yii::$app->cart->getCount();
        $minimumOrderAmount = $this->getMinimumOrderAmount();

        return [
            'qty' => $qtyCart,

            'html' => $this->renderPartial('_cart-view', [
                'orders' => $orders,
                'total_summ' => $totalSumm,
                'qty_cart' => $qtyCart,
                'minimumOrderAmount' => $minimumOrderAmount,
                'urls' => $this->getUrls(),
            ]),
            'order' => $this->renderPartial('/order/_totals-products', [
                'orders' => $orders,
                'total_summ' => $totalSumm,
                'minimumOrderAmount' => $minimumOrderAmount,
            ]),
        ];

    }

    protected function getUrls()
    {
        return [
            'urlUpdate' => Yii::$app->urlManager->createUrl(['cart/update']),
            'urlRemove' => Yii::$app->urlManager->createUrl(['cart/remove']),
        ];
    }
}