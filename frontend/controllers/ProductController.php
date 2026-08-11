<?php

namespace frontend\controllers;

use common\models\shop\MinimumOrderAmount;
use common\models\shop\AnalogProducts;
use common\models\shop\Faq;
use common\models\shop\Product;
use common\models\shop\ProductImage;
use common\models\shop\ProductPackaging;
use common\models\shop\ProductProperties;
use common\models\shop\Review;
use common\models\shop\Brand;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

class ProductController extends BaseFrontendController
{

    public function actionView($slug): string
    {
        $language = Yii::$app->language;
        $mobile = Yii::$app->devicedetect->isMobile();
        $webp_support = ProductImage::imageWebp();

        $product = $this->oneProduct($slug, $language);

        if ($product === null) {
            throw new NotFoundHttpException('Product not found ' . '" ' . $slug . ' "');
        }

        $faq = $this->faqProduct($product, $language);
        $productVariants = $this->variantsProduct($product);
        $products_analog = $this->analogsProduct($product);
        $products_analog_count = count($products_analog);
        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);
        $product_properties = $this->propertiesProduct($product, $language);
        $img_brand = Brand::find()->where(['id' => $product->brand_id])->one();
        $model_review = new Review();

        if ($language !== 'uk') {
            $this->translateProducts($products_analog, $language);
        }

        $schemaBreadcrumb = $product->getSchemaBreadcrumb();
        Yii::$app->params['breadcrumb'] = $schemaBreadcrumb->toScript();

        $schemaProduct = $product->getSchemaProduct();
        Yii::$app->params['product'] = $schemaProduct->toScript();

        Yii::$app->metamaster
            ->setIndexable(true)
            ->setType('product')
            ->setTitle($product->seo_title)
            ->setDescription(strip_tags($product->seo_description))
            ->setImage($product->getImgSeo($product->id))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
            ->setKeywords($product->keywords)
            ->setPrice($product->price)
            ->register(Yii::$app->view);

        return $this->render('index', [
            'product' => $product,
            'faq' => $faq,
            'mobile' => $mobile,
            'language' => $language,
            'webp_support' => $webp_support,
            'images' => $images,
            'productVariants' => $productVariants,
            'isset_to_cart' => $product->getIssetToCart($product->id),
            'model_review' => $model_review,
            'product_properties' => $product_properties,
            'img_brand' => $img_brand,
            'products_analog' => $products_analog,
            'products_analog_count' => $products_analog_count,
            'minimumOrderAmount' => MinimumOrderAmount::find()->select('amount')->scalar(),
        ]);
    }

    protected function oneProduct($slug, $language)
    {
        return Product::find()
            ->alias('p')
            ->select([
                'p.*',
                'name' => 'COALESCE(pt.name, p.name)',
                'description' => 'COALESCE(pt.description, p.description)',
                'short_description' => 'COALESCE(pt.short_description, p.short_description)',
                'footer_description' => 'COALESCE(pt.footer_description, p.footer_description)',
                'seo_title' => 'COALESCE(pt.seo_title, p.seo_title)',
                'seo_description' => 'COALESCE(pt.seo_description, p.seo_description)',
                'keywords' => 'COALESCE(pt.keywords, p.keywords)',
                'h1' => 'COALESCE(pt.h1, p.h1)',
            ])
            ->leftJoin('products_translate pt',
                'pt.product_id = p.id AND pt.language = :language')
            ->where(['p.slug' => $slug])
            ->addParams([':language' => $language])
            ->with([
                'images',
                'category' => function ($query) use ($language) {
                    $query->alias('c')
                        ->select([
                            'c.id',
                            'c.slug',
                            'c.parentId',
                            'name' => 'COALESCE(ct.name, c.name)',
                            'prefix' => 'COALESCE(ct.prefix, c.prefix)',
                        ])
                        ->leftJoin('categories_translate ct', 'ct.category_id = c.id AND ct.language = :language', [':language' => $language]);
                },
                'category.parent' => function ($query) use ($language) {
                    $query->alias('cp')
                        ->select([
                            'cp.id',
                            'cp.slug',
                            'name' => 'COALESCE(cpt.name, cp.name)',
                        ])
                        ->leftJoin('categories_translate cpt', 'cpt.category_id = cp.id AND cpt.language = :language', [':language' => $language]);
                },
            ])
            ->one();
    }

    protected function faqProduct($product, $language)
    {
        return Faq::find()
            ->alias('f')
            ->select([
                'COALESCE(ft.question, f.question) AS question',
                'COALESCE(ft.answer, f.answer) AS answer',
            ])
            ->leftJoin('faq_translate ft',
                'ft.faq_id = f.id AND ft.language = :language')
            ->where(['f.product_id' => $product->id])
            ->andWhere(['f.visible' => 1])
            ->addParams([':language' => $language])
            ->asArray()
            ->all();
    }

    protected function propertiesProduct($product, $language)
    {
        return ProductProperties::find()
            ->alias('pp')
            ->select([
                'COALESCE(pnt.name, pn.name) AS properties',
                'COALESCE(ppt.value, pp.value) AS value',
            ])
            ->leftJoin(
                'properties_name pn',
                'pn.id = pp.property_id'
            )
            ->leftJoin(
                'properties_name_translate pnt',
                'pnt.name_id = pn.id AND pnt.language = :language'
            )
            ->leftJoin(
                'product_properties_translate ppt',
                'ppt.product_properties_id = pp.id AND ppt.language = :language'
            )
            ->where(['pp.product_id' => $product->id])
            ->asArray()
            ->orderBy(['pn.sort' => SORT_ASC])
            ->addParams([':language' => $language])
            ->all();
    }

    protected function variantsProduct($product)
    {
        return ProductPackaging::find()
            ->alias('pp')
            ->select([
                'pp.volume',
                'p.slug',
                'p.status_id',
            ])
            ->leftJoin(
                'product p',
                'p.id = pp.product_variant_id'
            )
            ->where(['pp.product_id' => $product->id])
            ->asArray()
            ->all();
    }

    protected function analogsProduct($product)
    {
        return Product::find()
            ->alias('p')
            ->innerJoin(AnalogProducts::tableName() . ' ap', 'ap.analog_product_id = p.id')
            ->with(['category.parent', 'images'])
            ->where(['ap.product_id' => $product->id])
            ->all();
    }

    public function actionCreate(): string
    {
        if ($this->request->isPost) {
            $post = Yii::$app->request->post();
            $model = new Review();
            $model->product_id = $post['id'];
            $model->rating = $post['rating'];
            $model->name = $post['name'];
            $model->email = $post['email'];
            $model->message = $post['mess'];
            if ($model->save()) {
                $product = Product::find()->with('reviews')->where(['id' => $post['id']])->one();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->renderAjax('_review', [
                    'model_review' => $model,
                    'product' => $product
                ]);
            }
        }
    }

}
