<?php

namespace frontend\controllers;

use common\models\NpCity;
use common\models\NpWarehouses;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class NPController extends \yii\web\Controller
{
    public function actionCities()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedValue = $_POST['areaId'];

            $cities = ArrayHelper::map(NpCity::find()
                ->where(['area' => $selectedValue])
                ->asArray()
                ->all(), 'ref', 'description');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['cities' => $cities];
    }

    public function actionWarehouses()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedValue = $_POST['cityId'];

            $warehouses = ArrayHelper::map(NpWarehouses::find()
                ->where(['cityRef' => $selectedValue])
                ->asArray()
                ->all(), 'ref', 'description');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['warehouses' => $warehouses];
    }
}