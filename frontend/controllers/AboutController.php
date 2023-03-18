<?php


namespace frontend\controllers;


use common\models\About;
use yii\web\Controller;

class AboutController extends Controller
{

    public function actionView(){

        $model = About::find()->one();
        return $this->render('view', ['model' => $model]);
    }

}