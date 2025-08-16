<?php

namespace backend\widgets;

use common\models\shop\ActivePages;
use common\models\shop\Product;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class SubTopProducts extends Widget
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        // 1. Получаем все товары (slug => id)
        $monthsAgoTimestamp = strtotime('-5 months');
        
        $allProducts = Product::find()
            ->select(['id', 'slug', 'name'])
            ->where(['status_id' => 1])
            ->andWhere(['<', 'date_public', $monthsAgoTimestamp])
            ->orderBy(['date_updated' => SORT_ASC])
            ->indexBy('slug')
            ->asArray()
            ->all();

        // 2. Получаем все просмотры страниц с /product/
        $pages = ActivePages::find()
            ->select(['url_page', 'date_visit'])
            ->where(['like', 'url_page', '/product/'])
            ->asArray()
            ->all();

        // 3. Считаем просмотры по слагам
        $viewsCount = [];

        foreach ($pages as $page) {
            $url = $page['url_page'];
            $date = $page['date_visit'];

            if (str_contains($url, '/product/') !== false) {
                $parsedUrl = parse_url($url);
                $path = str_replace(['/en/', '/ru/'], '/', $parsedUrl['path']);
                $slug = trim(str_replace('/product/', '', $path), '/');

                if (!empty($slug)) {
                    if (isset($viewsCount[$slug])) {
                        $viewsCount[$slug]['count'] += 1;
                        if ($date > $viewsCount[$slug]['date']) {
                            $viewsCount[$slug]['date'] = $date;
                        }
                    } else {
                        $viewsCount[$slug] = [
                            'count' => 1,
                            'date' => $date,
                        ];
                    }
                }
            }
        }

        // 4. Находим товары с нулевым или малым числом просмотров
        $lowViewed = [];
        $threshold = 10; // Меньше 3 просмотров считается "мало"

        foreach ($allProducts as $slug => $product) {
            $count = $viewsCount[$slug]['count'] ?? 0;

            if ($count < $threshold) {
                $lowViewed[$slug] = [
                    'slug' => $slug,
                    'name' => $product['name'],
                    'count' => $count,
                    'date' => $viewsCount[$slug]['date'] ?? null,
                ];
            }
        }

        // Сортируем по количеству просмотров (по возрастанию)
        ArrayHelper::multisort($lowViewed, ['count'], [SORT_ASC]);

        // 5. Берем первые 10
        $results = array_slice($lowViewed, 0, 10);

        // 6. Добавляем картинки
        foreach ($results as &$result) {
            $productData = Product::find()
                ->alias('p')
                ->select([
                    'p.name',
                    'p.id',
                    'p.date_public',
                    'p.date_updated',
                    'pi.extra_small',
                ])
                ->leftJoin('product_image pi', 'pi.product_id = p.id')
                ->where(['p.slug' => $result['slug']])
                ->orderBy(['pi.priority' => SORT_ASC])
                ->asArray()
                ->one();

            if ($productData) {

                $result['date_public'] = $productData['date_public'];
                $result['date_updated'] = $productData['date_updated'];

                $result['image'] = $productData['extra_small'];
            } else {
                $result['image'] = null;
            }
        }

        return $this->render('recent-activity', [
            'results' => $results,
            'catalog' => 'product',
            'catalogImage' => 'product',
            'titleWidget' => 'Товари без переглядів або з дуже малими переглядами',
        ]);
    }
}