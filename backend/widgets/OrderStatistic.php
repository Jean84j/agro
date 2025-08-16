<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\OrderPayMent;
use common\models\shop\Order;
use common\models\shop\OrderStatus;

class OrderStatistic extends BaseWidgetBackend
{
    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $allStatusDelivery = OrderStatus::find()->asArray()->all();
        $allStatusPayment = OrderPayMent::find()->asArray()->all();

        $allStatusCountsDelivery = array_column($allStatusDelivery, null, 'name');
        $allStatusCountsPayment = array_column($allStatusPayment, null, 'name');

        $allStatusCountsDelivery = array_fill_keys(array_keys($allStatusCountsDelivery), 0);
        $allStatusCountsPayment = array_fill_keys(array_keys($allStatusCountsPayment), 0);

        $ordersStatus = Order::find()
            ->alias('o')
            ->select([
                'COALESCE(osd.name, "Не встановлено") AS status_delivery_name',
                'COALESCE(osp.name, "Не встановлено") AS status_payment_name',
            ])
            ->leftJoin('order_status osd', 'osd.id = o.order_status_id')
            ->leftJoin('order_pay_ment osp', 'osp.id = o.order_pay_ment_id')
            ->asArray()
            ->all();

        $statusDeliveryCounts = $statusPaymentCounts = [];

        foreach ($ordersStatus as $status) {
            $statusDeliveryCounts[$status['status_delivery_name']] = ($statusDeliveryCounts[$status['status_delivery_name']] ?? 0) + 1;
            $statusPaymentCounts[$status['status_payment_name']] = ($statusPaymentCounts[$status['status_payment_name']] ?? 0) + 1;
        }

        $newStatusDeliveryCounts = array_merge($allStatusCountsDelivery, $statusDeliveryCounts);
        $newStatusPaymentCounts = array_merge($allStatusCountsPayment, $statusPaymentCounts);

        arsort($newStatusDeliveryCounts);
        arsort($newStatusPaymentCounts);

        $countOrders = Order::find()->count();

        return $this->render('order-statistic', [
            'statusDeliveryCounts' => $newStatusDeliveryCounts,
            'statusPaymentCounts' => $newStatusPaymentCounts,
            'countOrders' => $countOrders,
        ]);
    }


}
