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

        return $this->render('recent-activity', [
            'results' => $results,
            'catalog' => 'product',
            'catalogImage' => 'product',
            'titleWidget' => 'Переглянуті користувачами товари',
        ]);
    }

}