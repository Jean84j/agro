<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\Brand;
use common\models\shop\Product;
use Yii;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class BrandsController extends BaseFrontendController
{

    public function actionView()
    {

        $brands = Brand::find()->all();

        $seo = Settings::seoPageTranslate('brands');
        $type = 'website';
        $title = $seo->title;
        $description = $seo->description;
        $image = '';
        $keywords = '';
        Settings::setMetamaster($type, $title, $description, $image, $keywords);

        return $this->render('view',
            [
                'brands' => $brands,
                'page_description' => $seo->page_description,
            ]);
    }

    public function actionCatalog($slug)
    {
        $language = Yii::$app->session->get('_language');

        $params = $this->setSortAndCount();
        $sort = $params['sort'];
        $count = $params['count'];

        $brand = Brand::find()->where(['slug' => $slug])->one();

        if ($brand === null) {
            throw new NotFoundHttpException('Brand not found ' . '" ' . $slug . ' "');
        }

        $query = Product::find()
            ->andWhere(['brand_id' => $brand->id])
            ->orderBy([
                new Expression('FIELD(status_id, 1, 3, 4, 2)')
            ]);

        $this->applySorting($query, $sort);

        $pages = $this->setPagination($query, $count);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $products_all = $query->count();

        $products = $this->translateProduct($products, $language);

        // Регистрация тега meta
        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'noindex, follow'
        ]);

        return $this->render('catalog', [
            'products' => $products,
            'products_all' => $products_all,
            'pages' => $pages,
            'brand' => $brand,
        ]);
    }

}