<?php

namespace frontend\controllers;

use common\models\Categories\AuxiliaryCategories;
use common\models\Categories\AuxiliaryTranslate;
use common\models\Categories\CategoriesTranslate;
use common\models\Categories\Category;
use common\models\shop\ProductsTranslate;
use common\models\shop\ProductProperties;
use common\models\shop\ProductTag;
use common\models\shop\Product;
use common\models\Tags\Tag;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Response;
use Yii;

class SearchController extends BaseFrontendController
{

    public function actionSuggestionsAjax(?string $q): string
    {
        $language = Yii::$app->language;
        $id_prod = $this->findProductIdsByQuery($q);
        $id_cat = $this->findCategoryIdsByQuery($q);
        $id_aux_cat = $this->findAuxCategoryIdsByQuery($q);

        Yii::$app->response->format = Response::FORMAT_JSON;

        $products = $this->getProducts($id_prod);
        $categories = $this->getCategories($id_cat, $language);
        $aux_categories = $this->getAuxCategories($id_aux_cat, $language);

        $categories_merge = array_merge($categories, $aux_categories);

        return $this->renderAjax('suggestions', [
            'products' => $products,
            'categories' => $categories_merge
        ]);
    }

    protected function getProducts($id_prod)
    {
        return Product::find()
            ->select(['id', 'slug', 'name', 'price', 'currency', 'status_id', 'sku', 'category_id'])
            ->orWhere(['in', 'id', $id_prod])
            ->limit(10)
            ->orderBy([new Expression('FIELD(status_id, 1, 3, 4, 2)')])
            ->all();
    }

    protected function getCategories($id_cat, $language)
    {
        return Category::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.slug',
                'c.parentId',
                'IFNULL(ct.name, c.name) AS name',
                'c.svg',
                'products' => new Expression("
            EXISTS(
                SELECT 1
                FROM product p
                WHERE p.category_id = c.id
                LIMIT 1
            )
        "),
            ])
            ->leftJoin('categories_translate ct', 'ct.category_id = c.id AND ct.language = :language')
            ->where(['in', 'c.id', $id_cat])
            ->andWhere(['c.visibility' => 1])
            ->addParams([':language' => $language])
            ->limit(4)
            ->asArray()
            ->all();
    }

    protected function getAuxCategories($id_aux_cat, $language)
    {
        return AuxiliaryCategories::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.slug',
                'IFNULL(ct.name, c.name) AS name',
                'c.svg',
                'products' => new Expression(2),
                'parentId' => new Expression('NULL'),
            ])
            ->leftJoin('auxiliary_translate ct', 'ct.category_id = c.id AND ct.language = :language')
            ->where(['in', 'c.id', $id_aux_cat])
            ->andWhere(['c.visibility' => 1])
            ->addParams([':language' => $language])
            ->limit(4)
            ->asArray()
            ->all();
    }

    public function actionSuggestions(?string $q): string
    {
        $language = Yii::$app->language;
        $layout = Yii::$app->session->get('selectedLayout', 'grid-3-sidebar');

        $id_prod = $this->findProductIdsByQuery($q);
        $id_cat = $this->findCategoryIdsByQuery($q);

        $categories = $this->getCategories($id_cat, $language);

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

        if ($language !== 'uk') {
            $products = $this->translateProducts($products, $language);
        }

        Yii::$app->metamaster
            ->setIndexable(false)
            ->setType('website')
//                ->setTitle($seo->title)
//                ->setDescription(strip_tags($seo->description))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
//            ->setImage('')
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

        return $this->render('suggestions-list', [
            'products' => $products,
            'pages' => $pages,
            'products_all' => $products_all,
            'categories' => $categories,
            'layout' => $layout,
        ]);
    }

    private function findProductIdsByQuery(?string $q = null): array
    {
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

    private function findCategoryIdsByQuery(?string $q = null): array
    {
        if (!$q) {
            return [];
        }

        $category_ids = Category::find()
            ->select('id')
            ->where(['like', 'name', $q])
            ->column();

        $category_ids_ru = CategoriesTranslate::find()
            ->select('category_id')
            ->where(['like', 'name', $q])
            ->column();

        $id_cat = array_merge($category_ids, $category_ids_ru);

        return array_unique($id_cat);
    }

    private function findAuxCategoryIdsByQuery(?string $q = null): array
    {
        if (!$q) {
            return [];
        }

        $aux_category_ids = AuxiliaryCategories::find()
            ->select('id')
            ->where(['like', 'name', $q])
            ->column();

        $aux_category_ids_ru = AuxiliaryTranslate::find()
            ->select('category_id')
            ->where(['like', 'name', $q])
            ->column();

        $id_aux_cat = array_merge($aux_category_ids, $aux_category_ids_ru);

        return array_unique($id_aux_cat);
    }


}