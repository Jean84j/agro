<?php

namespace frontend\controllers;

use common\models\shop\ProductProperties;
use common\models\shop\ProductsTranslate;
use common\models\shop\ProductTag;
use common\models\shop\Product;
use common\models\shop\Tag;
use yii\helpers\Html;
use yii\db\Expression;
use yii\web\Response;
use Yii;

class SearchController extends BaseFrontendController
{

    public function actionSuggestions($q = null)
    {
        $language = Yii::$app->language;

        $id_prod = [];
        $q = Html::encode($q);
        $q = trim($q);
        if ($q) {

            $id_tag = Tag::find()->select('id')->where(['like', 'name', $q])->column();
            if (!empty($id_tag)) {
                $tag_products = ProductTag::find()->select('product_id')->where(['in', 'tag_id', $id_tag])->column();
                $id_prod = array_merge($id_prod, $tag_products);
            }

            $val_products = ProductProperties::find()->select('product_id')->where(['like', 'value', $q])->column();
            $id_prod = array_merge($id_prod, $val_products);

            $product_ids = Product::find()
                ->select('id')
                ->where(['like', 'sku', $q])
                ->orWhere(['like', 'keywords', $q])
                ->orWhere(['like', 'name', $q])
                ->column();

            $product_ids_ru = ProductsTranslate::find()
                ->select('product_id')
                ->where(['like', 'keywords', $q])
                ->orWhere(['like', 'name', $q])
                ->column();

            $id_prod = array_merge($id_prod, $product_ids, $product_ids_ru);
        }

        $id_prod = array_unique($id_prod);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $products = Product::find()
                ->select(['id', 'slug', 'name', 'price', 'currency', 'status_id', 'sku', 'category_id'])
                ->orWhere(['in', 'id', $id_prod])
                ->limit(15)
                ->orderBy([new Expression('FIELD(status_id, 1, 3, 4, 2)')])
                ->all();

            return $this->renderAjax('suggestions', [
                'products' => $products
            ]);
        }

        $params = $this->setSortAndCount();
        $sort = $params['sort'];
        $count = $params['count'];

        $query = Product::find()
            ->select(['id', 'slug', 'name', 'price', 'currency', 'status_id', 'sku', 'category_id'])
            ->orWhere(['in', 'id', $id_prod])
            ->orderBy([new Expression('FIELD(status_id, 1, 3, 4, 2)')]);

        $this->applySorting($query, $sort);

        $pages = $this->setPagination($query, $count);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $products_all = $query->count();

        $products = $this->translateProduct($products, $language);

        return $this->render('suggestions-list', [
            'products' => $products,
            'pages' => $pages,
            'products_all' => $products_all,
        ]);
    }

}