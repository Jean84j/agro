<?php

namespace frontend\controllers;

use yii\web\NotFoundHttpException;
use common\models\shop\Product;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class CartController extends Controller
{
    public function actionCartView($id, $qty = 1)
    {

        $cart = Yii::$app->cart;

        $model = Product::find()->select(['id', 'price', 'name', 'slug', 'currency'])->where(['id' => $id])->one();

        !$model->getIssetToCart($model->id) ? '' : $qty = 0;

        if ($model) {
            $cart->put($model, $qty);
            return $this->renderPartial('cart-view', [
                'orders' => Yii::$app->cart->getPositions(),
                'total_summ' => Yii::$app->cart->getCost(),
                'qty_cart' => Yii::$app->cart->getCount(),
            ]);
        }
        throw new NotFoundHttpException();
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
        ]);
    }

    public function actionRemove($id)
    {
        $product = Product::findOne($id);
        if ($product) {
            Yii::$app->cart->remove($product);
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return $this->renderAjax('_cart-view', [
                    'orders' => Yii::$app->cart->getPositions(),
                    'total_summ' => Yii::$app->cart->getCost(),
                    'qty_cart' => Yii::$app->cart->getCount(),
                ]);
            }
        }
        return null;
    }

    public function actionQtyCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'orders' => Yii::$app->cart->getPositions(),
            'total_summ' => Yii::$app->cart->getCost(),
            'qty_cart' => Yii::$app->cart->getCount(),
        ];
    }

    public function actionUpdate($id, $qty = null)
    {
        $product = Product::findOne($id);
        Yii::$app->cart->update($product, $qty);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->renderAjax('_cart-view', [
            'orders' => Yii::$app->cart->getPositions(),
            'total_summ' => Yii::$app->cart->getCost(),
            'qty_cart' => Yii::$app->cart->getCount(),
        ]);
    }
}