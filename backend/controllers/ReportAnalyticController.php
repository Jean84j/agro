<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class ReportAnalyticController extends Controller
{
    public function actionIndex()
    {



        return $this->render('index');
    }

    public function actionDashboardTabContent()
    {

        $id = Yii::$app->request->post('id');

        switch ($id) {
            case 'order-tab':
                $content = $this->renderPartial('_order-tab-content');
                break;
            case 'review-tab':
                $content = $this->renderPartial('_review-tab-content');
                break;
            case 'views-tab':
                $content = $this->renderPartial('_views-tab-content');
                break;
            case 'top-10-tab':
                $content = $this->renderPartial('_top-10-tab-content');
                break;
            default:
                return [
                    'success' => false,
                    'error' => 'Unknown tab ID'
                ];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'content' => $content
        ];
    }

}
