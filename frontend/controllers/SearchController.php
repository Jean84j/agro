<?php

namespace frontend\controllers;

use common\models\shop\ProductProperties;
use common\models\shop\ProductsTranslate;
use common\models\shop\ProductTag;
use common\models\shop\Product;
use common\models\shop\Tag;
use yii\db\Expression;
use yii\web\Response;
use Yii;

class SearchController extends BaseFrontendController
{

    public function actionSuggestionsAjax(?string $q): string
    {
        $id_prod = $this->findProductIdsByQuery($q);

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

    public function actionSuggestions(?string $q): string
    {
        $language = Yii::$app->language;
        $id_prod = $this->findProductIdsByQuery($q);

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

    private function findProductIdsByQuery(?string $q): array
    {
        $q = trim($q);
        if (!$q) {
            return [];
        }

        $id_prod = [];

        // Поиск по тегам
        $id_tag = Tag::find()->select('id')->where(['like', 'name', $q])->column();
        if ($id_tag) {
            $tag_products = ProductTag::find()->select('product_id')->where(['in', 'tag_id', $id_tag])->column();
            $id_prod = array_merge($id_prod, $tag_products);
        }

        // Поиск по свойствам
        $val_products = ProductProperties::find()->select('product_id')->where(['like', 'value', $q])->column();
        $id_prod = array_merge($id_prod, $val_products);

        // Поиск по продуктам
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

        return array_unique($id_prod);
    }


}