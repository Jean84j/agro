<?php

namespace frontend\controllers;

use common\models\shop\Product;
use common\models\shop\Review;
use Yii;
use yii\web\Response;


class ReviewController extends \yii\web\Controller
{
    public function actionCreate()
    {
        if ($this->request->isPost) {
            $post = Yii::$app->request->post();
            $model = new Review();
            $model->product_id = $post['id'];
            $model->rating = $post['rating'];
            $model->name = $post['name'];
            $model->email = $post['email'];
            $model->message = $post['mess'];
            if ($model->save()) {
                $product = Product::find()->with('reviews')->where(['id' => $post['id']])->one();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->renderAjax('_review', [
                    'model_review' => $model,
                    'product' => $product
                ]);
            }else{
                return $product->reviews;
            }
        }
    }
}
