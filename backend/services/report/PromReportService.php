<?php

namespace backend\services\report;

use backend\models\ReportItem;

class PromReportService
{

    public function getReport($models): array
    {
        $data = $this->initData();

        foreach ($models as $model) {
            $this->processModel($model, $data);
        }

        return $this->buildResult($data);
    }

    private function initData(): array
    {
        return [
            'big' => [
                'qty' => [],
                'sum' => [],
                'incoming' => [],
                'discount' => [],
                'delivery' => [],
                'platform' => [],
            ],
            'small' => [
                'qty' => [],
                'sum' => [],
                'incoming' => [],
                'discount' => [],
                'delivery' => [],
                'platform' => [],
            ],
            'noPackage' => []
        ];
    }

    private function processModel($model, array &$data): void
    {
        $package = $model->getPackage($model->id);

        switch ($package) {
            case 'Фермерська':
                $this->processBigPackage($model, $data);
                break;

            case 'Дрібна':
                $this->processSmallPackage($model, $data);
                break;

            case 'Фермерська + Дрібна':
                $this->processMixedPackage($model, $data);
                break;

            default:
                $data['noPackage'][] = 'Не визначено';
        }
    }

    private function processBigPackage($model, array &$data): void
    {
        $data['big']['qty'][] = 1;
        $data['big']['sum'][] = $model->getTotalSumPeriod($model->id);
        $data['big']['incoming'][] = $model->getItemsIncomingPrice($model->id);
        $data['big']['discount'][] = $model->getItemsDiscount($model->id);
        $data['big']['platform'][] = $model->getItemsPlatformPrice($model->id);
        $data['big']['delivery'][] = $model->price_delivery;
    }

    private function processSmallPackage($model, array &$data): void
    {
        $data['small']['qty'][] = 1;
        $data['small']['sum'][] = $model->getTotalSumPeriod($model->id);
        $data['small']['incoming'][] = $model->getItemsIncomingPrice($model->id);
        $data['small']['discount'][] = $model->getItemsDiscount($model->id);
        $data['small']['platform'][] = $model->getItemsPlatformPrice($model->id);
        $data['small']['delivery'][] = $model->price_delivery;
    }

    private function processMixedPackage($model, array &$data): void
    {
        $data['big']['qty'][] = 1;
        $data['small']['qty'][] = 1;

        $data['small']['delivery'][] = $model->price_delivery;

        $items = ReportItem::find()
            ->where(['order_id' => $model->id])
            ->asArray()
            ->all();

        foreach ($items as $item) {
            $this->processItem($item, $data);
        }
    }

    private function processItem(array $item, array &$data): void
    {
        $type = $item['package'] === 'BIG' ? 'big' : 'small';
        $quantity = $item['quantity'];

        $data[$type]['sum'][] = $item['price'] * $quantity;
        $data[$type]['incoming'][] = $item['entry_price'] * $quantity;
        $data[$type]['discount'][] = $item['discount'];
        $data[$type]['platform'][] = $item['platform_price'];
    }

    private function buildResult(array $data): array
    {
        return [
            'bigQty' => count($data['big']['qty']),
            'bigSum' => array_sum($data['big']['sum']),
            'smallQty' => count($data['small']['qty']),
            'smallSum' => array_sum($data['small']['sum']),

            'bigDiscount' => array_sum($data['big']['discount']),
            'bigDelivery' => array_sum($data['big']['delivery']),
            'bigPlatform' => array_sum($data['big']['platform']),

            'smallDiscount' => array_sum($data['small']['discount']),
            'smallDelivery' => array_sum($data['small']['delivery']),
            'smallPlatform' => array_sum($data['small']['platform']),

            'bigIncomingPriceSum' => array_sum($data['big']['incoming']),
            'smallIncomingPriceSum' => array_sum($data['small']['incoming']),
        ];
    }

}
