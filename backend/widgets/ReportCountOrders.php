<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use backend\models\Report;

class ReportCountOrders extends BaseWidgetBackend
{
    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $total_orders = Report::find()
            ->where(['order_pay_ment_id' => 'Оплачено'])
            ->count();

        $formattedDate = $this->getPreviousMonthFormatted();

        return $this->render('total-sells', [
            'sum' => $total_orders,
            'formattedDate' => $formattedDate,
            'arrow' => 'down',
            'percentage' => '73',
            'title' => 'Всього оплачених замовлень',
            'count' => true,
        ]);
    }


}
