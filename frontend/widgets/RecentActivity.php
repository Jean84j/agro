<?php

namespace backend\widgets;

use common\models\shop\ActivePages;
use common\models\shop\Product;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class RecentActivity extends Widget
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $pages = ActivePages::find()
            ->select(['url_page', 'date_visit'])
            ->where(['like', 'url_page', '/product/'])
            ->asArray()
            ->all();
        $uniqueUrls = [];
        $result = [];
        foreach ($pages as $page) {
            $url = $page['url_page'];
            $date = $page['date_visit'];

            if (str_contains($url, '/product/') !== false) {
                $parsedUrl = parse_url($url);
                $url = $parsedUrl['path'];
                $url = str_replace(['/en/', '/ru/'], '/', $url);
                $url = str_replace('/product/', '', $url);

                if (isset($uniqueUrls[$url])) {
                    $uniqueUrls[$url]['count'] += 1;
                    if ($date > $uniqueUrls[$url]['date']) {
                        $uniqueUrls[$url]['date'] = $date;
                    }
                } else {
                    $uniqueUrls[$url] = [
                        'slug' => str_replace('/product/', '', $url),
                        'date' => $date,
                        'count' => 1,
                    ];
                }
            }
        }

        ArrayHelper::multisort($result, ['date'], [SORT_DESC]);

        $results = array_slice($uniqueUrls, 0, 10);

        foreach ($results as &$result) {
            $productData = Product::find()
                ->alias('p')
                ->select([
                    'p.name',
                    'p.id',
                    'pi.extra_small',
                ])
                ->leftJoin('product_image pi', 'pi.product_id = p.id')
                ->where(['p.slug' => $result['slug']])
                ->orderBy(['pi.priority' => SORT_ASC])
                ->asArray()
                ->one();

            if ($productData) {
                $result['name'] = $productData['name'];
                $result['image'] = $productData['extra_small'];
            }
        }

        ArrayHelper::multisort($results, ['date'], [SORT_DESC]);

        return $this->render('recent-activity', ['results' => $results]);
    }

}