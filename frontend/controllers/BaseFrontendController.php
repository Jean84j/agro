<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\db\Expression;

class BaseFrontendController extends Controller
{
    /**
     * Применяет сортировку в запрос.
     *
     * @param \yii\db\QueryInterface $query
     * @param string $sort
     */
    protected function applySorting($query, $sort)
    {
        if ($sort === 'price_lowest') {
            $query->orderBy(['price' => SORT_ASC]);
        } elseif ($sort === 'price_highest') {
            $query->orderBy(['price' => SORT_DESC]);
        } elseif ($sort === 'name_a') {
            $query->orderBy(['name' => SORT_ASC]);
        } elseif ($sort === 'name_z') {
            $query->orderBy(['name' => SORT_DESC]);
        } else {
            $query->orderBy([new Expression('FIELD(status_id, 1, 3, 4, 2)')]);
        }
    }

    /**
     *
     *
     */
    protected function translateProduct($products, $language)
    {
        if ($language !== 'uk') {
            foreach ($products as $product) {
                if ($product) {
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
        return $products;
    }

    protected function translateCategory($category, $language)
    {
        if ($language !== 'uk') {
            if ($category) {
                $translationCat = $category->getTranslation($language)->one();
                if ($translationCat) {
                    if ($translationCat->name) {
                        $category->name = $translationCat->name;
                    }
                    if ($translationCat->h1) {
                        $category->h1 = $translationCat->h1;
                    }
                    if ($translationCat->description) {
                        $category->description = $translationCat->description;
                    }
                    if ($translationCat->pageTitle) {
                        $category->pageTitle = $translationCat->pageTitle;
                    }
                    if ($translationCat->metaDescription) {
                        $category->metaDescription = $translationCat->metaDescription;
                    }
                }
            }
        }
        return $category;
    }

    /**
     *
     *
     */
    protected function setSortAndCount()
    {
        if (!Yii::$app->session->has('sort')) {
            Yii::$app->session->set('sort', '');
        } else {
            if (Yii::$app->request->post('sort') !== null) {
                Yii::$app->session->set('sort', Yii::$app->request->post('sort'));
            }
        }
        $sort = Yii::$app->session->get('sort');

        if (!Yii::$app->session->has('count')) {
            Yii::$app->session->set('count', 12);
        } else {
            if (Yii::$app->request->post('count') !== null) {
                Yii::$app->session->set('count', Yii::$app->request->post('count'));
            }
        }
        $count = intval(Yii::$app->session->get('count'));

        return ['sort' => $sort, 'count' => $count];
    }

    /**
     *
     *
     */
    protected function setPagination($query, $count)
    {
        return new Pagination([
            'totalCount' => $query->count(), 'pageSize' => $count,
            'forcePageParam' => false, 'pageSizeParam' => false
        ]);

    }

    /**
     *
     *
     */
    protected function getRelativeFiles(string $aliasPath, bool $recursive = false): array
    {
        $path = Yii::getAlias($aliasPath);
        $webroot = str_replace('\\', '/', Yii::getAlias('@webroot'));

        $files = FileHelper::findFiles($path, [
            'recursive' => $recursive,
        ]);

        $relative = array_map(function ($file) use ($webroot) {
            $file = str_replace('\\', '/', $file);
            return str_replace($webroot, '', $file);
        }, $files);

        sort($relative);

        return $relative;
    }
}
