<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use backend\models\Report;
use backend\models\ReportItem;

class ReportSumPayment extends BaseWidgetBackend
{
    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $sum = ReportItem::find()
            ->where(['order_id' => Report::find()
                ->select('id')
                ->where(['order_pay_ment_id' => 'Оплачено'])
            ])
            ->sum('price * quantity');

        return $this->render('total-sells', [
            'sum' => $sum ?? 0,
            'formattedDate' => $this->getPreviousMonthFormatted(),
            'arrow' => 'down',
            'percentage' => '73',
            'title' => 'Сумма оплачених замовлень',
        ]);
    }



}
