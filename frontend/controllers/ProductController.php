<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\AnalogProducts;
use common\models\shop\Faq;
use common\models\shop\MinimumOrderAmount;
use common\models\shop\Product;
use common\models\shop\ProductImage;
use common\models\shop\ProductPackaging;
use common\models\shop\ProductProperties;
use common\models\shop\Review;
use common\models\shop\Brand;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function actionView($slug): string
    {
        $language = Yii::$app->session->get('_language', 'uk');

        $mobile = Yii::$app->devicedetect->isMobile();

        $webp_support = ProductImage::imageWebp();

        $product = Product::find()->with(['category.parent', 'images'])->where(['slug' => $slug])->one();

        if ($product === null) {
            throw new NotFoundHttpException('Product not found ' . '" ' . $slug . ' "');
        }


        $faq = Faq::find()
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


        $productVariants = ProductPackaging::find()
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

        $products_analog = Product::find()
            ->alias('p')
            ->innerJoin(AnalogProducts::tableName() . ' ap', 'ap.analog_product_id = p.id')
            ->with(['category.parent', 'images'])
            ->where(['ap.product_id' => $product->id])
            ->all();
        $products_analog_count = count($products_analog);

        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);

        $product_properties = ProductProperties::find()
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

        $img_brand = Brand::find()->where(['id' => $product->brand_id])->one();
        $model_review = new Review();

        if ($language !== 'uk') {
            $this->getProductTranslation($product, $language, $products_analog);
        }

        $schemaBreadcrumb = $product->getSchemaBreadcrumb();
        Yii::$app->params['breadcrumb'] = $schemaBreadcrumb->toScript();

        $schemaProduct = $product->getSchemaProduct();
        Yii::$app->params['product'] = $schemaProduct->toScript();

        $type = 'product';
        $title = $product->seo_title;
        $description = $product->seo_description;
        $image = $product->getImgSeo($product->id);
        $keywords = $product->keywords;
        Settings::setMetamaster($type, $title, $description, $image, $keywords);

        $this->setAlernateUrl($slug);

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

    protected function getProductTranslation($product, $language, $products_analog)
    {
        if ($product) {
            $translationProd = $product->getTranslation($language)->one();
            if ($translationProd) {
                if ($translationProd->name) {
                    $product->name = $translationProd->name;
                }
                if ($translationProd->description) {
                    $product->description = $translationProd->description;
                }
                if ($translationProd->short_description) {
                    $product->short_description = $translationProd->short_description;
                }
                if ($translationProd->footer_description) {
                    $product->footer_description = $translationProd->footer_description;
                }
                if ($translationProd->seo_title) {
                    $product->seo_title = $translationProd->seo_title;
                }
                if ($translationProd->seo_description) {
                    $product->seo_description = $translationProd->seo_description;
                }
                if ($translationProd->keywords) {
                    $product->keywords = $translationProd->keywords;
                }
                if ($translationProd->h1) {
                    $product->h1 = $translationProd->h1;
                }
            }
            $translationCat = $product->category->getTranslation($language)->one();
            if ($translationCat) {
                if ($translationCat->name) {
                    $product->category->name = $translationCat->name;
                }
                if ($translationCat->prefix) {
                    $product->category->prefix = $translationCat->prefix;
                }
            }
            if ($product->category->parent) {
                $translationCatParent = $product->category->parent->getTranslation($language)->one();
                if ($translationCatParent) {
                    if ($translationCatParent->name) {
                        $product->category->parent->name = $translationCatParent->name;
                    }
                }
            }
        }
        if ($products_analog) {
            foreach ($products_analog as $product) {
                $translationProd = $product->getTranslation($language)->one();
                if ($translationProd) {
                    if ($translationProd->name) {
                        $product->name = $translationProd->name;
                    }
                }
                $translationCat = $product->category->getTranslation($language)->one();
                if ($translationCat) {
                    if ($translationCat->name) {
                        $product->category->name = $translationCat->name;
                    }
                    if ($translationCat->prefix) {
                        $product->category->prefix = $translationCat->prefix;
                    }
                }
            }
        }
    }

    protected function setAlernateUrl($slug)
    {
        $url = Yii::$app->request->hostInfo;
        $ukUrl = $url . '/product/' . $slug;
        $enUrl = $url . '/en/product/' . $slug;
        $ruUrl = $url . '/ru/product/' . $slug;

        $alternateUrls = [
            'ukUrl' => $ukUrl,
            'enUrl' => $enUrl,
            'ruUrl' => $ruUrl,
        ];

        Yii::$app->params['alternateUrls'] = $alternateUrls;
    }

}
