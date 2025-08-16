<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\Report;
use common\models\ReportItem;

class ReportAverageCost extends BaseWidgetBackend
{
    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $result = ReportItem::find()
            ->select([
                'total_sales' => 'SUM(price * quantity)',
                'total_quantity' => 'SUM(quantity)'
            ])
            ->where(['order_id' => Report::find()
                ->select('id')
                ->where(['order_pay_ment_id' => 'Оплачено'])
            ])
            ->asArray()
            ->one();

        $totalSales = $result['total_sales'] ?? 0;
        $totalQuantity = $result['total_quantity'] ?? 1;

        // Вычисляем среднюю стоимость продажи
        $averageSalePrice = $totalSales / max($totalQuantity, 1);

        return $this->render('total-sells', [
            'sum' => $averageSalePrice,
            'formattedDate' => $this->getPreviousMonthFormatted(),
            'arrow' => 'down',
            'percentage' => '73',
            'title' => 'Середня сумма замовлення',
        ]);
    }

}
