<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use backend\models\ProductsBackend;
use yii\helpers\ArrayHelper;

class RecentActivity extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $uniqueUrls = $this->getProductUniqueUrls();

        ArrayHelper::multisort($uniqueUrls, ['date'], [SORT_DESC]);

        $results = array_slice($uniqueUrls, 0, 10);

        foreach ($results as &$result) {
            $productData = ProductsBackend::find()
                ->alias('p')
                ->select([
                    'p.name',
                    'p.id',
                    'p.views AS count',
                    'pi.extra_small',
                ])
                ->leftJoin(
                    ['pi' => '(SELECT product_id, MIN(extra_small) AS extra_small FROM product_image GROUP BY product_id)'],
                    'pi.product_id = p.id'
                )
                ->where(['p.slug' => $result['slug']])
                ->asArray()
                ->one();

            if ($productData) {
                $result['name'] = $productData['name'];
                $result['image'] = $productData['extra_small'];
                $result['count'] = $productData['count'];
            }
        }

        return $this->render('recent-activity', [
            'results' => $results,
            'catalog' => 'product',
            'catalogImage' => 'product',
            'titleWidget' => 'Переглянуті користувачами товари',
        ]);
    }

}