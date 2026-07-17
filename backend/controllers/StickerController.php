<?php
namespace backend\controllers;

use yii\web\Controller;

class StickerController extends Controller
{
    public function actionIndex()
    {

        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
        ]);
    }
}