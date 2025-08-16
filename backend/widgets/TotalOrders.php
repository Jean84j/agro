<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\shop\Order;

class TotalOrders extends BaseWidgetBackend
{
    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $total_orders = Order::find()
            ->where(['order_pay_ment_id' => 3])
            ->count();

        $formattedDate = $this->getPreviousMonthFormatted();

        return $this->render('total-sells', [
            'sum' => $total_orders,
            'formattedDate' => $formattedDate,
            'arrow' => 'down',
            'percentage' => '73',
            'title' => 'Всього замовлень',
            'count' => true,
        ]);
    }


}
