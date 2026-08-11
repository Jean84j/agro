<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\AuxiliaryCategories;
use common\models\shop\CategoriesProperties;
use common\models\shop\ProductProperties;
use common\models\shop\Category;
use common\models\shop\Product;
use Spatie\SchemaOrg\Schema;
use yii\db\Expression;
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
        $language = Yii::$app->language;
        $categories = $this->categories($language);

        $auxiliaryCategories = $this->popularAuxiliaryCategories($language);

        $seo = Settings::seoPageTranslate('catalog');
        $url = Url::canonical();
        $image = '';

        Yii::$app->metamaster
            ->setIndexable(true)
            ->setType('website')
            ->setTitle($seo->title)
            ->setDescription(strip_tags($seo->description))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
//            ->setImage('')
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

        $this->setCatalogSchema($seo->title, $seo->description, $image, $url);

        $files = $this->getRelativeFiles('@webroot/images/catalog-categories');

        return $this->render('list',
            [
                'categories' => $categories,
                'auxiliaryCategories' => $auxiliaryCategories,
                'language' => $language,
                'page_description' => $seo->page_description,
                'files' => $files,
            ]);
    }

    protected function categories($language)
    {
        return Category::find()
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
    }

    protected function popularAuxiliaryCategories($language)
    {
        return Yii::$app->cache->getOrSet(
            'auxiliary_categories_random_12',
            static function ($language) {
                return AuxiliaryCategories::find()
                    ->alias('c')
                    ->select([
                        'c.id',
                        'c.slug',
                        'c.image',
                        'name' => 'COALESCE(ct.name, c.name)',
                        'c.visibility',
                    ])
                    ->leftJoin('auxiliary_translate ct', 'ct.category_id = c.id AND ct.language = :language')
                    ->orderBy(new Expression('RAND()'))
                    ->limit(12)
                    ->andWhere(['c.visibility' => 1])
                    ->addParams([':language' => $language])
                    ->all();
            },
            60 * 60 * 24 // 24 часа
        );
    }

    protected function setCatalogSchema($title, $description, $image, $url)
    {
        $catalog = Schema::collectionPage()
            ->name($title)
            ->description($description)
            ->url($url)
            ->image($image)
            ->publisher(
                Schema::organization()
                    ->name('AgroPro')
                    ->url('https://agropro.org.ua')
            );

        Yii::$app->params['schema'] = $catalog->toScript();
    }

    public function actionChildren($slug)
    {
        $language = Yii::$app->language;

        $category = $this->category($slug, $language);

        Yii::$app->metamaster
            ->setIndexable(true)
            ->setType('website')
            ->setTitle($category->pageTitle)
            ->setDescription(strip_tags($category->metaDescription))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
            ->setImage('/images/category/' . $category->file)
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

        $this->setChildrenProductSchema($category);

        return $this->render('children',
            [
                'category' => $category,
                'language' => $language,
            ]);
    }

    protected function category($slug, $language)
    {
        $category = Category::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.slug',
                'c.file',
                'c.parentId',
                'c.visibility',
                'c.svg',
                'c.name AS original_name',
                'c.h1 AS original_h1',
                'c.description AS original_description',
                'c.pageTitle AS original_pageTitle',
                'c.metaDescription AS original_metaDescription',
                'name' => 'COALESCE(ct.name, c.name)',
                'h1' => 'COALESCE(ct.h1, c.h1)',
                'description' => 'COALESCE(ct.description, c.description)',
                'pageTitle' => 'COALESCE(ct.pageTitle, c.pageTitle)',
                'metaDescription' => 'COALESCE(ct.metaDescription, c.metaDescription)',
            ])
            ->leftJoin('categories_translate ct', 'ct.category_id = c.id AND ct.language = :language')
            ->where(['c.slug' => $slug, 'c.visibility' => 1])
            ->addParams([':language' => $language])
            ->with(['parents.translations' => function ($query) use ($language) {
                $query->andWhere(['language' => $language]);
            }
            ])
            ->one();

        if ($category && !empty($category->parents)) {
            foreach ($category->parents as $parent) {
                if (!empty($parent->translations)) {
                    $translation = $parent->translations[0] ?? null;
                    if ($translation && !empty($translation->name)) {
                        $parent->name = $translation->name;
                    }
                }
            }
        }
        return $category;
    }

    public function actionCatalog($slug)
    {
        $language = Yii::$app->language;
        $mobile = Yii::$app->devicedetect->isMobile();

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

        $auxiliaryCategories = $this->auxiliaryCategories($category->id, $language);

        $propertiesFilter = $this->propertiesFilter($category->id, $language);

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

            $products = $this->translateProducts($products, $language);


        }

        $this->setCatalogBreadCrumbSchema($category);
        $this->setCatalogProductSchema($category, $products_all);

        Yii::$app->metamaster
            ->setIndexable(true)
            ->setType('website')
            ->setTitle($category->pageTitle)
            ->setDescription(strip_tags($category->metaDescription))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
            ->setImage('/images/category/' . $category->file)
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

        return $this->render('catalog',
            compact([
                'products',
                'category',
                'pages',
                'products_all',
                'propertiesFilter',
                'auxiliaryCategories',
                'language',
                'mobile',
            ]));
    }

    protected function auxiliaryCategories($category_id, $language)
    {
        return AuxiliaryCategories::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.parentId',
                'c.slug',
                'c.image',
                'name' => 'COALESCE(ct.name, c.name)',
                'c.visibility',
                'c.svg',
            ])
            ->leftJoin('auxiliary_translate ct', 'ct.category_id = c.id AND ct.language = :language')
            ->where(['c.parentId' => $category_id])
            ->andWhere(['c.visibility' => 1])
            ->addParams([':language' => $language])
            ->all();

    }

    protected function propertiesFilter($category_id, $language)
    {
        return CategoriesProperties::find()
            ->alias('cp')
            ->select([
                'cp.property_id',
                'cp.category_id',
                'pn.sort', // Полезно добавить, если нужно знать порядок на фронтенде
                'name' => 'COALESCE(pnt.name, pn.name, "")',
            ])
            ->leftJoin(
                'properties_name pn',
                'pn.id = cp.property_id'
            )
            ->leftJoin(
                'properties_name_translate pnt',
                'pnt.name_id = pn.id AND pnt.language = :language'
            )
            ->where(['cp.category_id' => $category_id])
            ->orderBy(['pn.sort' => SORT_ASC])
            ->addParams([':language' => $language])
            ->asArray()
            ->all();
    }


    public function actionAuxiliaryCatalog($slug)
    {
        $language = Yii::$app->language;

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

        if ($language !== 'uk') {
            $category = $this->translateCategory($category, $language);
            $products = $this->translateProducts($products, $language);
        }

        $this->setAuxiliaryCatalogBreadCrumbSchema($category, $breadcrumbCategory);
        $this->setAuxiliaryCatalogProductSchema($category, $products_all, $productsId);

        Yii::$app->metamaster
            ->setIndexable(true)
            ->setType('website')
            ->setTitle($category->pageTitle)
            ->setDescription(strip_tags($category->metaDescription))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
            ->setImage('/images/auxiliary-categories/' . $category->image)
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

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
        $url = self::getUrlForSchema();

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
                ->url(Url::canonical())
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
        $url = self::getUrlForSchema();

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
            ->url(Url::canonical())
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
        $url = self::getUrlForSchema();

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
            ->url(Url::canonical())
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
        $url = self::getUrlForSchema();

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
        $url = self::getUrlForSchema();

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

    protected function getUrlForSchema(): string
    {
        $language = Yii::$app->language;

        if ($language !== 'uk') {
            $url = Yii::$app->request->hostInfo . '/' . $language;
        } else {
            $url = Yii::$app->request->hostInfo;
        }

        return rtrim($url, '/') . '/';
    }

}
