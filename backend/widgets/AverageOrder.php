<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\shop\OrderItem;
use common\models\shop\Order;

class AverageOrder extends BaseWidgetBackend
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $result = OrderItem::find()
            ->select([
                'total_sales' => 'SUM(price * quantity)',
                'total_quantity' => 'SUM(quantity)'
            ])
            ->where(['order_id' => Order::find()
                ->select('id')
                ->where(['order_pay_ment_id' => 3])
            ])
            ->asArray()
            ->one();

        $totalSales = $result['total_sales'] ?? 0;
        $totalQuantity = $result['total_quantity'] ?? 1;

        $averageCost = $totalSales / max($totalQuantity, 1);

        $formattedDate = $this->getPreviousMonthFormatted();

        return $this->render('total-sells', [
            'sum' => $averageCost,
            'formattedDate' => $formattedDate,
            'arrow' => 'down',
            'percentage' => '73',
            'title' => 'Середня вартість замовлення',
        ]);
    }

}