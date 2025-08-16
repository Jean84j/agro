<?php

namespace frontend\controllers;

use common\models\Posts;
use common\models\SeoPages;
use common\models\shop\AuxiliaryCategories;
use common\models\shop\Category;
use common\models\shop\Product;
use common\models\shop\Tag;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteMapController extends Controller
{
    //Карта сайта. Выводит в виде XML файла.
    public function actionSitemap(): string
    {
        $siteMapBase = 1;
        $arr = ['sitemap-products.xml', 'sitemap-categories.xml', 'sitemap-articles.xml', 'sitemap-pages.xml', 'sitemap-tags.xml'];

        $updates = [
            Product::find()->select(['date_updated'])->orderBy(['date_updated' => SORT_DESC])->scalar(),
            max(
                Category::find()->select(['date_updated'])->orderBy(['date_updated' => SORT_DESC])->scalar(),
                AuxiliaryCategories::find()->select(['date_updated'])->orderBy(['date_updated' => SORT_DESC])->scalar()
            ),
            Posts::find()->select(['date_updated'])->orderBy(['date_updated' => SORT_DESC])->scalar(),
            SeoPages::find()->select(['date_updated'])->orderBy(['date_updated' => SORT_DESC])->scalar(),
            Tag::find()->select(['date_updated'])->orderBy(['date_updated' => SORT_DESC])->scalar(),
        ];

        $arrDate = array_map(function ($update) {
            return !empty($update) ? date(DATE_W3C, $update) : date(DATE_W3C, time());
        }, $updates);

        $xml_array = $this->renderPartial('sitemap', [
            'host' => Yii::$app->request->hostInfo,
            'urls' => $arr,
            'date' => $arrDate,
            'siteMapBase' => $siteMapBase,
        ]);

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');

        return $xml_array;
    }


    public function actionSitemapProducts(): string
    {
        $arr = array();

        $products = Product::find()
            ->select(['id', 'slug', 'date_updated', 'name', 'category_id'])
            ->with(['category', 'images'])
            ->all();
        foreach ($products as $product) {
            $arr[] = array(
                'loc' => '/product/' . $product->slug,
                'lastmod' => !empty($product->date_updated) ? date(DATE_W3C, $product->date_updated) : date(DATE_W3C, time()),
                'image' => '/product/' . $product->images[0]->webp_name,
                'caption' => $product->category->prefix . ' ' . $product->name,
                'priority' => '0.8',
                'changefreq' => 'daily',
            );
        }

        // Отправляем данные на отображение без шаблона
        $xml_array = $this->renderPartial('sitemap', array(
            'host' => Yii::$app->request->hostInfo, // Имя хоста
            'urls' => $arr, // Полученный массив
        ));

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $xml_array;
    }

    public function actionSitemapCategories(): string
    {
        $arr = array();

        $categories = Category::find()
            ->select(['id', 'slug', 'date_updated', 'visibility', 'name', 'file'])
            ->all();
        foreach ($categories as $category) {
            if ($category->visibility == 1) {
                $catalog = $category->getCategoryStatus($category->id);
                $arr[] = array(
                    'loc' => $catalog . $category->slug,
                    'lastmod' => !empty($category->date_updated) ? date(DATE_W3C, $category->date_updated) : date(DATE_W3C, time()),
                    'image' => '/images/category/' . $category->file,
                    'caption' => $category->name,
                    'priority' => '0.7',
                    'changefreq' => 'Weekly',
                );
            }
        }

        $auxCategories = AuxiliaryCategories::find()
            ->select(['slug', 'date_updated', 'name', 'image'])
            ->all();
        foreach ($auxCategories as $auxCategory) {
            $arr[] = array(
                'loc' => '/auxiliary-product-list/' . $auxCategory->slug,
                'lastmod' => !empty($auxCategory->date_updated) ? date(DATE_W3C, $auxCategory->date_updated) : date(DATE_W3C, time()),
                'image' => '/images/auxiliary-categories/' . $auxCategory->image,
                'caption' => $auxCategory->name,
                'priority' => '0.7',
                'changefreq' => 'Weekly',
            );
        }

        // Отправляем данные на отображение без шаблона
        $xml_array = $this->renderPartial('sitemap', array(
            'host' => Yii::$app->request->hostInfo, // Имя хоста
            'urls' => $arr, // Полученный массив
        ));

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $xml_array;
    }

    public function actionSitemapArticles(): string
    {
        $arr = array();

        $posts = Posts::find()
            ->select(['slug', 'date_updated', 'title', 'webp_image'])
            ->all();
        foreach ($posts as $post) {
            $arr[] = array(
                'loc' => '/post/' . $post->slug,
                'lastmod' => !empty($post->date_updated) ? date(DATE_W3C, $post->date_updated) : date(DATE_W3C, time()),
                'image' => '/posts/' . $post->webp_image,
                'caption' => $post->title,
                'priority' => '0.6',
                'changefreq' => 'monthly',
            );
        }

        // Отправляем данные на отображение без шаблона
        $xml_array = $this->renderPartial('sitemap', array(
            'host' => Yii::$app->request->hostInfo, // Имя хоста
            'urls' => $arr, // Полученный массив
        ));

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $xml_array;
    }

    public function actionSitemapPages(): string
    {
        $arr = array();

        $excludedSlugs = ['home', 'delivery', 'compare', 'wish', 'about'];

        $pages = SeoPages::find()
            ->select(['slug', 'date_updated'])
            ->where(['not in', 'slug', $excludedSlugs])
            ->all();

        foreach ($pages as $page) {
            $arr[] = array(
                'loc' => '/' . $page->slug,
                'lastmod' => !empty($page->date_updated) ? date(DATE_W3C, $page->date_updated) : date(DATE_W3C, time()),
                'priority' => '0.5',
                'changefreq' => 'monthly',
            );
        }

        // Отправляем данные на отображение без шаблона
        $xml_array = $this->renderPartial('sitemap', array(
            'host' => Yii::$app->request->hostInfo, // Имя хоста
            'urls' => $arr, // Полученный массив
        ));

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $xml_array;
    }

    public function actionSitemapTags(): string
    {
        $arr = array();

        $pages = Tag::find()
            ->select(['slug', 'date_updated'])
            ->where(['<>', 'visibility', false])
            ->all();
        foreach ($pages as $page) {
            $arr[] = array(
                'loc' => '/tag/' . $page->slug,
                'lastmod' => !empty($page->date_updated) ? date(DATE_W3C, $page->date_updated) : date(DATE_W3C, time()),
                'priority' => '0.5',
                'changefreq' => 'monthly',
            );
        }

        // Отправляем данные на отображение без шаблона
        $xml_array = $this->renderPartial('sitemap', array(
            'host' => Yii::$app->request->hostInfo, // Имя хоста
            'urls' => $arr, // Полученный массив
        ));

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $xml_array;
    }

    //Продукты сайта. Выводит в виде XML файла.
    public function actionSiteProductsMerchant(): string
    {
        $products = Product::find()
            ->with('images', 'brand', 'category')
            ->all();

        $xml_array = $this->renderPartial('site-products-merchant-qlt5vh8de0rhf', [
            'products' => $products
        ]);

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $xml_array;
    }
}