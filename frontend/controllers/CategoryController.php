<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\AuxiliaryCategories;
use common\models\shop\CategoriesProperties;
use common\models\shop\ProductProperties;
use common\models\shop\Category;
use common\models\shop\Product;
use Spatie\SchemaOrg\Schema;
use yii\helpers\Url;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * CategoryController for Category model.
 */
class CategoryController extends BaseFrontendController
{
    public function actionList()
    {
        $language = Yii::$app->session->get('_language', 'uk');
        $categories = Category::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.slug',
                'c.parentId',
                'c.file',
                'IFNULL(ct.name, c.name) AS name',
                'c.visibility',
                'c.svg',
            ])
            ->leftJoin('categories_translate ct', 'ct.category_id = c.id AND ct.language = :language')
            ->where(['c.parentId' => null])
            ->andWhere(['c.visibility' => 1])
            ->addParams([':language' => $language])
            ->all();

        $seo = Settings::seoPageTranslate('catalog');
        $type = 'website';
        $title = $seo->title;
        $description = $seo->description;
        $image = '';
        $keywords = '';
        Settings::setMetamaster($type, $title, $description, $image, $keywords);

        return $this->render('list',
            [
                'categories' => $categories,
                'language' => $language,
                'page_description' => $seo->page_description,
            ]);
    }

    public function actionChildren($slug)
    {
        $language = Yii::$app->session->get('_language', 'uk');

        $category = Category::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.slug',
                'c.file',
                'c.parentId',
                'c.name AS original_name', // Оригинальное название категории
                'IFNULL(ct.name, c.name) AS name', // Переведенное название категории
                'c.h1 AS original_h1',
                'IFNULL(ct.h1, c.h1) AS h1',
                'c.description AS original_description',
                'IFNULL(ct.description, c.description) AS description',
                'c.pageTitle AS original_pageTitle',
                'IFNULL(ct.pageTitle, c.pageTitle) AS pageTitle',
                'c.metaDescription AS original_metaDescription',
                'IFNULL(ct.metaDescription, c.metaDescription) AS metaDescription',
                'c.visibility',
                'c.svg',
            ])
            ->leftJoin('categories_translate ct', 'ct.category_id = c.id AND ct.language = :language') // Присоединение переводов категории
            ->leftJoin('categories_translate ctp', 'ctp.category_id = c.parentId AND ctp.language = :language') // Присоединение переводов родительской категории
            ->where(['c.slug' => $slug]) // Фильтрация по слагу
            ->andWhere(['c.visibility' => 1]) // Только видимые категории
            ->addParams([':language' => $language]) // Добавление параметра языка
            ->one();

        if ($category->parents) {
            foreach ($category->parents as $parent) {
                if ($parent !== null) {
                    $translationCatParent = $parent->getTranslation($language)->one();
                    if ($translationCatParent) {
                        $parent->name = $translationCatParent->name;
                    }
                }
            }
        }

        $type = 'website';
        $title = $category->pageTitle;
        $description = $category->metaDescription;
        $image = '/category/' . $category->file;
        $keywords = '';
        Settings::setMetamaster($type, $title, $description, $image, $keywords);

        $this->setChildrenProductSchema($category);

        return $this->render('children',
            [
                'category' => $category,
                'language' => $language,
            ]);
    }

    public function actionCatalog($slug)
    {
//       Yii::$app->session->removeAll();
        $language = Yii::$app->session->get('_language', 'uk');

        $params = $this->setSortAndCount();
        $sort = $params['sort'];
        $count = $params['count'];

        $brandCheck = Yii::$app->request->post('brandCheck');
        $propertiesCheck = Yii::$app->request->post('propertiesCheck');
        $minPrice = Yii::$app->request->post('minPrice');
        $maxPrice = Yii::$app->request->post('maxPrice');

        Yii::$app->session->set('brandCheckFilter', $brandCheck);
        Yii::$app->session->set('propertiesCheckFilter', $propertiesCheck);
        Yii::$app->session->set('minPriceFilter', $minPrice);
        Yii::$app->session->set('maxPriceFilter', $maxPrice);

        $category = Category::find()->where(['slug' => $slug])->one();

        if ($category === null) {
            throw new NotFoundHttpException('Category not found ' . '" ' . $slug . ' "');
        }

        $auxiliaryCategories = AuxiliaryCategories::find()
            ->where(['parentId' => $category->id])
            ->andWhere(['visibility' => 1])
            ->all();

        $propertiesFilter = CategoriesProperties::find()
            ->alias('cp')
            ->select([
                'cp.property_id',
                'cp.category_id',
                'COALESCE(pnt.name, pn.name) AS name',
            ])
            ->leftJoin(
                'properties_name pn',
                'pn.id = cp.property_id'
            )
            ->leftJoin(
                'properties_name_translate pnt',
                'pnt.name_id = pn.id AND pnt.language = :language'
            )
            ->where(['cp.category_id' => $category->id])
            ->orderBy(['pn.sort' => SORT_ASC])
            ->addParams([':language' => $language])
            ->asArray()
            ->all();

        $query = Product::find()->where(['category_id' => $category->id]);

        $query->andFilterWhere(['>=', 'price', $minPrice])
            ->andFilterWhere(['<=', 'price', $maxPrice]);

        if ($propertiesCheck !== null) {
            $queryProdId = ProductProperties::find()
                ->select('product_id')
                ->where(['category_id' => $category->id]);

            foreach ($propertiesCheck as $value) {
                $subQuery = ProductProperties::find()
                    ->select('product_id')
                    ->where(['category_id' => $category->id])
                    ->andWhere(['like', 'value', $value]);

                $queryProdId->andWhere(['in', 'product_id', $subQuery]);
            }
            $productsId = $queryProdId->column();

            $query->andFilterWhere(['in', 'id', $productsId]);
        }

        if ($brandCheck !== null) {
            $query->andFilterWhere(['in', 'brand_id', $brandCheck]);
        }

        $this->applySorting($query, $sort);

        $pages = $this->setPagination($query, $count);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $products_all = $query->count();

        if ($language !== 'uk') {

            $category = $this->translateCategory($category, $language);

            if ($category->parent) {
                $translationCatParent = $category->parent->getTranslation($language)->one();
                if ($translationCatParent) {
                    if ($translationCatParent->name) {
                        $category->parent->name = $translationCatParent->name;
                    }
                }
            }
            if ($category->parent) {
                if ($category->parent->parents) {
                    foreach ($category->parent->parents as $parent) {
                        $translationCatParentsParent = $parent->getTranslation($language)->one();
                        if ($translationCatParentsParent) {
                            if ($translationCatParentsParent->name) {
                                $parent->name = $translationCatParentsParent->name;
                            }
                        }
                    }
                }
            }

            $products = $this->translateProduct($products, $language);

            if ($auxiliaryCategories) {
                foreach ($auxiliaryCategories as $auxiliaryCategory) {
                    if ($auxiliaryCategory) {
                        $translationAuxiliaryCategory = $auxiliaryCategory->getTranslation($language)->one();
                        if ($translationAuxiliaryCategory) {
                            if ($translationAuxiliaryCategory->name) {
                                $auxiliaryCategory->name = $translationAuxiliaryCategory->name;
                            }
                        }
                    }
                }
            }
        }

        $this->setCatalogBreadCrumbSchema($category);
        $this->setCatalogProductSchema($category, $products_all);

        $type = 'product.group';
        $title = $category->pageTitle;
        $description = $category->metaDescription;
        $image = '/category/' . $category->file;
        $keywords = '';
        $url = Url::canonical();
        Settings::setMetamaster($type, $title, $description, $image, $keywords, $url);

        return $this->render('catalog',
            compact([
                'products',
                'category',
                'pages',
                'products_all',
                'propertiesFilter',
                'auxiliaryCategories',
                'language',
            ]));
    }

    public function actionAuxiliaryCatalog($slug)
    {
        $language = Yii::$app->session->get('_language', 'uk');

        $params = $this->setSortAndCount();
        $sort = $params['sort'];
        $count = $params['count'];

//        $brandCheck = Yii::$app->request->post('brandCheck');
//        $propertiesCheck = Yii::$app->request->post('propertiesCheck');
//        $minPrice = Yii::$app->request->post('minPrice');
//        $maxPrice = Yii::$app->request->post('maxPrice');
//
//        Yii::$app->session->set('brandCheckFilter', $brandCheck);
//        Yii::$app->session->set('propertiesCheckFilter', $propertiesCheck);
//        Yii::$app->session->set('minPriceFilter', $minPrice);
//        Yii::$app->session->set('maxPriceFilter', $maxPrice);


        $category = AuxiliaryCategories::find()->where(['slug' => $slug])->one();

        if ($category === null) {
            throw new NotFoundHttpException('Category Auxiliary not found ' . '" ' . $slug . ' "');
        }

        $breadcrumbCategory = Category::find()->where(['id' => $category->parentId])->one();

        $categoryId = $category->parentId;

        $subQuery = ProductProperties::find()
            ->select('product_id')
            ->where(['category_id' => $categoryId])
            ->andWhere(['like', 'value', $category->object]);

        $productsId = $subQuery->column();

//        $propertiesFilter = ProductProperties::find()
//            ->select(['properties'])
//            ->distinct()
//            ->where(['category_id' => $categoryId])
//            ->orderBy(['sort' => SORT_ASC])
//            ->column();

        $query = Product::find()->where(['id' => $productsId]);

//        $query->andFilterWhere(['>=', 'price', $minPrice])
//            ->andFilterWhere(['<=', 'price', $maxPrice]);

//        if ($propertiesCheck !== null) {
//            $queryProdId = ProductProperties::find()
//                ->select('product_id')
//                ->where(['category_id' => $categoryId]);
//
//            foreach ($propertiesCheck as $value) {
//                $subQuery = ProductProperties::find()
//                    ->select('product_id')
//                    ->where(['category_id' => $categoryId])
//                    ->andWhere(['like', 'value', $value]);
//
//                $queryProdId->andWhere(['in', 'product_id', $subQuery]);
//            }
//            $productsId = $queryProdId->column();
//
//            $query->andFilterWhere(['in', 'id', $productsId]);
//        }
//
//        if ($brandCheck !== null) {
//            $query->andFilterWhere(['in', 'brand_id', $brandCheck]);
//        }

        $this->applySorting($query, $sort);

        $pages = $this->setPagination($query, $count);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $products_all = $query->count();

        $category = $this->translateCategory($category, $language);
        $products = $this->translateProduct($products, $language);


        $this->setAuxiliaryCatalogBreadCrumbSchema($category, $breadcrumbCategory);
        $this->setAuxiliaryCatalogProductSchema($category, $products_all, $productsId);

        $type = 'product.group';
        $title = $category->pageTitle;
        $description = $category->metaDescription;
        $image = '/images/auxiliary-categories/' . $category->image;
        $keywords = '';
        $url = Url::canonical();
        Settings::setMetamaster($type, $title, $description, $image, $keywords, $url);

        return $this->render('view',
            compact([
                'products',
                'category',
                'pages',
                'products_all',
                'breadcrumbCategory',
                'language',
//                'propertiesFilter',
//                'auxiliaryCategories',
            ]));
    }


    protected function setChildrenProductSchema($category)
    {
        $language = Yii::$app->session->get('_language', 'uk');

        if ($language !== 'uk') {
            $url = Yii::$app->request->hostInfo . '/' . $language;
        } else {
            $url = Yii::$app->request->hostInfo;
        }

        $url = rtrim($url, '/') . '/';

        $res = [];
        foreach ($category->parents as $cat) {
            if ($cat->parentId === $category->id) {
                $res[] = $cat->id;
            }
        }

        $results = Product::find()->where(['category_id' => $res])->all();

        $offers = [];
        foreach ($results as $product) {
            $offer = [
                "url" => $url . 'product/' . $product->slug
            ];
            $offers[] = $offer;
        }

        $products_all = count($offers);

        if ($res) {
            $productList = Schema::Product()
                ->name($category->name)
                ->url($url . 'catalog/' . $category->slug)
                ->description(
                mb_strlen(strip_tags($category->description)) > 500
                    ? mb_substr(strip_tags($category->description), 0, 497) . '...'
                    : strip_tags($category->description)
            )
                ->image(Yii::$app->request->hostInfo . '/images/category/' . $category->file)
                ->aggregateRating(Schema::aggregateRating()
                    ->ratingValue($category->getSchemaRatingChildren($res))
                    ->reviewCount($category->getSchemaCountReviewsChildren($res)))
                ->offers(Schema::AggregateOffer()
                    ->highPrice($category->getChildrenHighPrice($res))
                    ->lowPrice($category->getChildrenLowPrice($res))
                    ->offerCount($products_all)
                    ->priceCurrency("UAH")
                    ->offers($offers));
            Yii::$app->params['schema'] = $productList->toScript();
        }
    }

    protected function setCatalogProductSchema($category, $products_all)
    {
        $language = Yii::$app->session->get('_language', 'uk');

        if ($language !== 'uk') {
            $url = Yii::$app->request->hostInfo . '/' . $language;
        } else {
            $url = Yii::$app->request->hostInfo;
        }

        $url = rtrim($url, '/') . '/';

        $results = Product::find()->where(['category_id' => $category->id])->all();
        $offers = [];
        foreach ($results as $product) {

            $offer = [
                "url" => $url . 'product/' . $product->slug
            ];
            $offers[] = $offer;
        }

        $productList = Schema::Product()
            ->name($category->name)
            ->url($url)
            ->description(
                mb_strlen(strip_tags($category->description)) > 500
                    ? mb_substr(strip_tags($category->description), 0, 497) . '...'
                    : strip_tags($category->description)
            )
            ->image(Yii::$app->request->hostInfo . '/images/category/' . $category->file)
            ->aggregateRating(Schema::aggregateRating()
                ->ratingValue($category->getSchemaRatingCategory($category->id))
                ->reviewCount($category->getSchemaCountReviewsCategory($category->id)))
            ->offers(Schema::AggregateOffer()
                ->highPrice($category->getCatalogHighPrice($category->id))
                ->lowPrice($category->getCatalogLowPrice($category->id))
                ->offerCount($products_all)
                ->priceCurrency("UAH")
                ->offers($offers));
        Yii::$app->params['schema'] = $productList->toScript();
    }

    protected function setAuxiliaryCatalogProductSchema($category, $products_all, $productsId)
    {
        $language = Yii::$app->session->get('_language', 'uk');

        if ($language !== 'uk') {
            $url = Yii::$app->request->hostInfo . '/' . $language;
        } else {
            $url = Yii::$app->request->hostInfo;
        }

        $url = rtrim($url, '/') . '/';

        $results = Product::find()->where(['id' => $productsId])->all();
        $offers = [];
        foreach ($results as $product) {
            $offer = [
                "url" => $url . 'product/' . $product->slug
            ];
            $offers[] = $offer;
        }

        $productList = Schema::Product()
            ->name($category->name)
            ->url($url . 'auxiliary-product-list/' . $category->slug)
            ->description(
                mb_strlen(strip_tags($category->description)) > 500
                    ? mb_substr(strip_tags($category->description), 0, 497) . '...'
                    : strip_tags($category->description)
            )
            ->image(Yii::$app->request->hostInfo . '/images/auxiliary-categories/' . $category->image)
            ->aggregateRating(Schema::aggregateRating()
                ->ratingValue($category->getSchemaRatingCategory($productsId))
                ->reviewCount($category->getSchemaCountReviewsCategory($productsId)))
            ->offers(Schema::AggregateOffer()
                ->highPrice($category->getCatalogHighPrice($productsId))
                ->lowPrice($category->getCatalogLowPrice($productsId))
                ->offerCount($products_all)
                ->priceCurrency("UAH")
                ->offers($offers));

        Yii::$app->params['schema'] = $productList->toScript();
    }

    protected function setCatalogBreadCrumbSchema($category)
    {

        $language = Yii::$app->session->get('_language', 'uk');

        if ($language !== 'uk') {
            $url = Yii::$app->request->hostInfo . '/' . $language;
        } else {
            $url = Yii::$app->request->hostInfo;
        }

        $url = rtrim($url, '/') . '/';

        if (isset($category->parent->name)) {
            $schemaBreadcrumb = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(Schema::thing()->name(Yii::t('app', 'Головна'))
                            ->url($url)
                            ->setProperty('id', $url)),
                    Schema::listItem()
                        ->position(2)
                        ->item(Schema::thing()->name($category->parent->name)
                            ->url(Url::to(['category/children', 'slug' => $category->parent->slug]))
                            ->setProperty('id', Url::to(['category/children', 'slug' => $category->parent->slug]))),
                    Schema::listItem()
                        ->position(3)
                        ->item(Schema::thing()->name($category->name)
                            ->url(Url::to(['category/catalog', 'slug' => $category->slug]))
                            ->setProperty('id', Url::to(['category/catalog', 'slug' => $category->slug]))),
                ]);
        } else {
            $schemaBreadcrumb = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(Schema::thing()->name(Yii::t('app', 'Головна'))
                            ->url($url)
                            ->setProperty('id', $url)),
                    Schema::listItem()
                        ->position(2)
                        ->item(Schema::thing()->name(Yii::t('app', 'Категорії'))
                            ->url(Url::to(['category/list']))
                            ->setProperty('id', Url::to(['category/list']))),
                    Schema::listItem()
                        ->position(3)
                        ->item(Schema::thing()->name($category->name)
                            ->url(Url::to(['category/catalog', 'slug' => $category->slug]))
                            ->setProperty('id', Url::to(['category/catalog', 'slug' => $category->slug]))),
                ]);
        }

        Yii::$app->params['breadcrumb'] = $schemaBreadcrumb->toScript();
    }

    protected function setAuxiliaryCatalogBreadCrumbSchema($category, $breadcrumbCategory)
    {
        $language = Yii::$app->session->get('_language', 'uk');

        if ($language !== 'uk') {
            $url = Yii::$app->request->hostInfo . '/' . $language;
        } else {
            $url = Yii::$app->request->hostInfo;
        }

        $url = rtrim($url, '/') . '/';

        $schemaBreadcrumb = Schema::breadcrumbList()
            ->itemListElement([
                Schema::listItem()
                    ->position(1)
                    ->item(Schema::thing()->name(Yii::t('app', 'Головна'))
                        ->url($url)
                        ->setProperty('id', $url)),
                Schema::listItem()
                    ->position(2)
                    ->item(Schema::thing()->name($breadcrumbCategory->name)
                        ->url(Url::to(['category/catalog', 'slug' => $breadcrumbCategory->slug]))
                        ->setProperty('id', Url::to(['category/catalog', 'slug' => $breadcrumbCategory->slug]))),
                Schema::listItem()
                    ->position(3)
                    ->item(Schema::thing()->name($category->name)
                        ->url(Url::to(['category/auxiliary-catalog', 'slug' => $category->slug]))
                        ->setProperty('id', Url::to(['category/auxiliary-catalog', 'slug' => $category->slug]))),
            ]);

        Yii::$app->params['breadcrumb'] = $schemaBreadcrumb->toScript();
    }

}
