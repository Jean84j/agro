<?php

namespace frontend\controllers;

use common\models\Posts;
use common\models\PostsReview;
use Yii;
use yii\web\Response;

class PostsReviewController extends \yii\web\Controller
{
    public function actionCreate()
    {
        if ($this->request->isPost) {
            $post = Yii::$app->request->post();

            $model = new PostsReview();
            $model->post_id = $post['id'];
            $model->rating = $post['rating'];
            $model->name = $post['name'];
            $model->email = $post['email'];
            $model->message = $post['mess'];
            if ($model->save()) {
                $res = Posts::find()->with('reviews')->where(['id' => $post['id']])->one();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->renderAjax('_review', [
                    'model_review' => $model,
                    'res' => $res
                ]);
            }else{
                return '';
            }
        }
    }
}