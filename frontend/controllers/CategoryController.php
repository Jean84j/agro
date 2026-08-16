<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\AuxiliaryCategories;
use common\models\shop\Brand;
use common\models\shop\CategoriesProperties;
use common\models\shop\ProductProperties;
use common\models\shop\Category;
use common\models\shop\Product;
use Spatie\SchemaOrg\Schema;
use yii\db\Expression;
use yii\helpers\Url;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
        $randomIds = Yii::$app->cache->getOrSet('popular_auxiliary_categories_ids', function () {
            return AuxiliaryCategories::find()
                ->select('id')
                ->where(['visibility' => 1])
                ->orderBy(new Expression('RAND()'))
                ->limit(12)
                ->column();
        }, 60 * 60 * 24); // 24 часа

        if (empty($randomIds)) {
            return [];
        }

        $cacheKey = 'auxiliary_categories_list_' . $language;

        return Yii::$app->cache->getOrSet(
            $cacheKey,
            function () use ($language, $randomIds) {
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
                    ->where(['c.id' => $randomIds])
                    ->addParams([':language' => $language])
                    ->all();
            },
            60 * 60 * 24
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
        $layout = Yii::$app->session->get('selectedLayout', 'grid-3-sidebar');

        $params = $this->setSortAndCount();
        $sort = $params['sort'];
        $count = $params['count'];

        // 1. Поиск категории
        $category = Category::find()->where(['slug' => $slug])->one();
        if ($category === null) {
            throw new NotFoundHttpException('Category not found "' . $slug . '"');
        }

        $filterBrandsItem = $this->getFilterBrands($category->id);

        // СБРОС СЕССИИ: Если перешли в ДРУГУЮ категорию — очищаем старые фильтры
        $lastCategoryId = Yii::$app->session->get('last_category_id');
        if ($lastCategoryId !== $category->id) {
            Yii::$app->session->remove('minPriceFilter');
            Yii::$app->session->remove('maxPriceFilter');
            Yii::$app->session->remove('filter_radio_brand_check');
            Yii::$app->session->set('last_category_id', $category->id);
        }

        // 2. Логика получения Бренда
        $getBrand = Yii::$app->request->get('filter_radio_brand');
        if ($getBrand !== null) {
            $filterBrandId = $getBrand;
            Yii::$app->session->set('filter_radio_brand_check', $filterBrandId);
        } else {
            $filterBrandId = Yii::$app->session->get('filter_radio_brand_check', '');
        }

        // 3. Логика получения Цен
        if (Yii::$app->request->get('minPrice') !== null || Yii::$app->request->get('maxPrice') !== null) {
            $minPrice = Yii::$app->request->get('minPrice');
            $maxPrice = Yii::$app->request->get('maxPrice');
        } elseif ($getBrand !== null) {
            // Сменили бренд -> сбрасываем цены под новый бренд
            $minPrice = null;
            $maxPrice = null;
        } else {
            // Берем из сессии
            $minPrice = Yii::$app->session->get('minPriceFilter');
            $maxPrice = Yii::$app->session->get('maxPriceFilter');
        }

        $auxiliaryCategories = $this->auxiliaryCategories($category->id, $language);
        $propertiesFilter = $this->propertiesFilter($category->id, $language);

        // 4. Считаем абсолютные границы цен категории / выбранного бренда (ЧИСТЫЙ ЗАПРОС)
        $boundsQuery = Product::find()->where(['category_id' => $category->id]);
        if (!empty($filterBrandId)) {
            $boundsQuery->andWhere(['brand_id' => $filterBrandId]);
        }

        $categoryMinPrice = floor((float)$boundsQuery->min('price'));
        $categoryMaxPrice = ceil((float)$boundsQuery->max('price'));

        // Защита, если в категории нет цен или товары пустые
        if ($categoryMinPrice <= 0 && $categoryMaxPrice <= 0) {
            $categoryMinPrice = 0;
            $categoryMaxPrice = 1000;
        }

        // Подгоняем выбранные цены в актуальные рамки
        if ($minPrice === null || $minPrice < $categoryMinPrice || $minPrice > $categoryMaxPrice) {
            $minPrice = $categoryMinPrice;
        }
        if ($maxPrice === null || $maxPrice > $categoryMaxPrice || $maxPrice < $categoryMinPrice) {
            $maxPrice = $categoryMaxPrice;
        }

        // Сохраняем реальные валидные цены в сессию
        Yii::$app->session->set('minPriceFilter', $minPrice);
        Yii::$app->session->set('maxPriceFilter', $maxPrice);

        // 5. Формируем основной запрос для ТОВАРОВ
        $query = Product::find()->where(['category_id' => $category->id]);
        $category_products_all = (int)$query->count();

        // Фильтр: Бренд
        if (!empty($filterBrandId)) {
            $query->andWhere(['brand_id' => $filterBrandId]);
        }

        // Фильтр: Цена
        if ($minPrice > $categoryMinPrice) {
            $query->andWhere(['>=', 'price', (float)$minPrice]);
        }
        if ($maxPrice < $categoryMaxPrice) {
            $query->andWhere(['<=', 'price', (float)$maxPrice]);
        }

        // 6. Сортировка и пагинация
        $this->applySorting($query, $sort);

        $products_all = (int)$query->count();
        $pages = $this->setPagination($query, $count);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        // Переводы
        if ($language !== 'uk') {
            $category = $this->translateCategory($category, $language);
            $products = $this->translateProducts($products, $language);
        }

        // SEO & Schema
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
            ->register(Yii::$app->view);

        $renderParams = [
            'products' => $products,
            'category' => $category,
            'filterBrandsItem' => $filterBrandsItem,
            'pages' => $pages,
            'products_all' => $products_all,
            'category_products_all' => $category_products_all,
            'propertiesFilter' => $propertiesFilter,
            'auxiliaryCategories' => $auxiliaryCategories,
            'language' => $language,
            'mobile' => $mobile,
            'layout' => $layout,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'categoryMinPrice' => $categoryMinPrice,
            'categoryMaxPrice' => $categoryMaxPrice,
        ];

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'success' => true,
                'categoryMinPrice' => $categoryMinPrice,
                'categoryMaxPrice' => $categoryMaxPrice,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'html' => $this->renderPartial('_ajax-products-list', $renderParams),
            ];
        }

        return $this->render('catalog', $renderParams);
    }

    protected function getFilterBrands($category_id)
    {
        return Brand::find()
            ->alias('b')
            ->select([
                'b.id',
                'b.name',
                'count' => 'COUNT(p.id)',
            ])
            ->innerJoin(
                ['p' => Product::tableName()],
                'p.brand_id = b.id AND p.category_id = :category_id',
                [':category_id' => $category_id]
            )
            ->groupBy(['b.id', 'b.name'])
            ->orderBy(['count' => SORT_DESC])
            ->asArray()
            ->all();
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
        $layout = Yii::$app->session->get('selectedLayout', 'grid-3-sidebar');

        $params = $this->setSortAndCount();
        $sort = $params['sort'];
        $count = $params['count'];




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


        $filterBrandsItem = $this->getFilterBrandsAux($productsId, $category->object);


        $query = Product::find()->where(['id' => $productsId]);
        $category_products_all = (int)$query->count();

        $lastCategoryId = Yii::$app->session->get('last_category_id');
        if ($lastCategoryId !== $category->id) {
            Yii::$app->session->remove('minPriceFilter');
            Yii::$app->session->remove('maxPriceFilter');
            Yii::$app->session->remove('filter_radio_brand_check');
            Yii::$app->session->set('last_category_id', $category->id);
        }

        // 2. Логика получения Бренда
        $getBrand = Yii::$app->request->get('filter_radio_brand');
        if ($getBrand !== null) {
            $filterBrandId = $getBrand;
            Yii::$app->session->set('filter_radio_brand_check', $filterBrandId);
        } else {
            $filterBrandId = Yii::$app->session->get('filter_radio_brand_check', '');
        }

        // 3. Логика получения Цен
        if (Yii::$app->request->get('minPrice') !== null || Yii::$app->request->get('maxPrice') !== null) {
            $minPrice = Yii::$app->request->get('minPrice');
            $maxPrice = Yii::$app->request->get('maxPrice');
        } elseif ($getBrand !== null) {
            // Сменили бренд -> сбрасываем цены под новый бренд
            $minPrice = null;
            $maxPrice = null;
        } else {
            // Берем из сессии
            $minPrice = Yii::$app->session->get('minPriceFilter');
            $maxPrice = Yii::$app->session->get('maxPriceFilter');
        }


        // 4. Считаем абсолютные границы цен категории / выбранного бренда (ЧИСТЫЙ ЗАПРОС)
        $boundsQuery = Product::find()->where(['id' => $productsId]);
        if (!empty($filterBrandId)) {
            $boundsQuery->andWhere(['brand_id' => $filterBrandId]);
        }

        $categoryMinPrice = floor((float)$boundsQuery->min('price'));
        $categoryMaxPrice = ceil((float)$boundsQuery->max('price'));

        // Защита, если в категории нет цен или товары пустые
        if ($categoryMinPrice <= 0 && $categoryMaxPrice <= 0) {
            $categoryMinPrice = 0;
            $categoryMaxPrice = 1000;
        }

        // Подгоняем выбранные цены в актуальные рамки
        if ($minPrice === null || $minPrice < $categoryMinPrice || $minPrice > $categoryMaxPrice) {
            $minPrice = $categoryMinPrice;
        }
        if ($maxPrice === null || $maxPrice > $categoryMaxPrice || $maxPrice < $categoryMinPrice) {
            $maxPrice = $categoryMaxPrice;
        }

        // Сохраняем реальные валидные цены в сессию
        Yii::$app->session->set('minPriceFilter', $minPrice);
        Yii::$app->session->set('maxPriceFilter', $maxPrice);


        // Фильтр: Бренд
        if (!empty($filterBrandId)) {
            $query->andWhere(['brand_id' => $filterBrandId]);
        }

        // Фильтр: Цена
        if ($minPrice > $categoryMinPrice) {
            $query->andWhere(['>=', 'price', (float)$minPrice]);
        }
        if ($maxPrice < $categoryMaxPrice) {
            $query->andWhere(['<=', 'price', (float)$maxPrice]);
        }



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

        $renderParams = [
            'products' => $products,
            'category' => $category,
            'filterBrandsItem' => $filterBrandsItem,
            'pages' => $pages,
            'products_all' => $products_all,
            'category_products_all' => $category_products_all,
            'language' => $language,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'categoryMinPrice' => $categoryMinPrice,
            'categoryMaxPrice' => $categoryMaxPrice,
            'breadcrumbCategory' => $breadcrumbCategory,
            'layout' => $layout,
        ];

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'success' => true,
                'categoryMinPrice' => $categoryMinPrice,
                'categoryMaxPrice' => $categoryMaxPrice,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'html' => $this->renderPartial('_ajax-products-list', $renderParams),
            ];
        }

        return $this->render('auxiliary', $renderParams);
    }

    protected function getFilterBrandsAux($productsId, $object)
    {
        return Brand::find()
            ->alias('b')
            ->select([
                'b.id',
                'b.name',
                'count' => 'COUNT(DISTINCT p.id)',
            ])
            ->innerJoin(
                ['p' => Product::tableName()],
                'p.brand_id = b.id'
            )
            ->innerJoin(
                ['pp' => ProductProperties::tableName()],
                'pp.product_id = p.id'
            )
            ->where(['p.id' => $productsId])
            ->andWhere(['like', 'pp.value', $object])
            ->groupBy(['b.id', 'b.name'])
            ->orderBy(['count' => SORT_DESC])
            ->asArray()
            ->all();
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
