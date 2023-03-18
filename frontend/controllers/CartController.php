<?php


namespace frontend\controllers;


use common\models\shop\Product;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends Controller
{
    public function actionQuickview($id, $qty = 1){

        $cart = Yii::$app->cart;

        $model = Product::findOne($id);
        if ($model) {
            $cart->put($model, $qty);
        return $this->renderPartial('quickview', [
            'orders' => Yii::$app->cart->getPositions(),
            'total_summ' => Yii::$app->cart->getCost(),
            'qty_cart' => \Yii::$app->cart->getCount(),
        ]);
        }
        throw new NotFoundHttpException();

    }

    public function actionQuickviewAll(){

        return $this->renderPartial('quickview', [
            'orders' => Yii::$app->cart->getPositions(),
            'total_summ' => Yii::$app->cart->getCost(),
            'qty_cart' => \Yii::$app->cart->getCount(),
        ]);

    }

    public function actionRemove($id)
    {
        $product = Product::findOne($id);
        if ($product) {
            \Yii::$app->cart->remove($product);
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->renderAjax('_quickview', [
                    'orders' => Yii::$app->cart->getPositions(),
                    'total_summ' => Yii::$app->cart->getCost(),
                    'qty_cart' => \Yii::$app->cart->getCount(),
                ]);
            }
        }
    }

    public function actionQtyCart(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'orders' => Yii::$app->cart->getPositions(),
            'total_summ' => Yii::$app->cart->getCost(),
            'qty_cart' => \Yii::$app->cart->getCount(),
        ];
    }

    public function actionUpdate($id, $qty)
    {
        $product = Product::findOne($id);
        \Yii::$app->cart->update($product, $qty);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->renderAjax('_quickview', [
            'orders' => Yii::$app->cart->getPositions(),
            'total_summ' => Yii::$app->cart->getCost(),
            'qty_cart' => \Yii::$app->cart->getCount(),
        ]);

    }

}