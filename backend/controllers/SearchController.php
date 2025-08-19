<?php

namespace backend\controllers;

use common\models\Report;
use common\models\shop\Category;
use common\models\shop\Product;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SearchController extends Controller
{
    public function actionAjaxSearch($search): ?string
    {
        $search = trim($search);
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (empty($search)) {
            return null;
        }

        // Общая функция для поиска
        $searchQuery = function ($model, $attribute, $limit) use ($search) {
            return $model::find()
                ->where(['like', $attribute, $search])
                ->limit($limit)
                ->all();
        };

        $categories = $searchQuery(Category::class, 'name', 5);
        $products = $searchQuery(Product::class, 'name', 10);
        $reports = Report::find()
            ->where(['like', 'fio', $search])
            ->orWhere(['like', 'tel_number', $search])
            ->limit(20)
            ->all();

        if (!empty($categories) || !empty($products) || !empty($reports)) {
            return $this->renderAjax('suggestions', [
                'categories' => $categories,
                'products' => $products,
                'reports' => $reports,
            ]);
        }

        return null;
    }

}
