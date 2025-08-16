<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\shop\Order;


class IncomeStatistics extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $startDate = date('Y-m-01 00:00:00', strtotime('-11 months'));
        $endDate = date('Y-m-t 23:59:59');

        $orders = Order::find()
            ->where(['order_pay_ment_id' => 3])
            ->andWhere(['between', 'created_at', strtotime($startDate), strtotime($endDate)])
            ->all();

        $carts = [];
        $ukrainian_months = $this->getUkrainianMonths();

        foreach ($orders as $order) {

            $month_name = date('M', $order->created_at);
            $ukrainian_month_name = $ukrainian_months[$month_name] ?? '';

            $carts[] = [
                "label" => $ukrainian_month_name,
                "value" => $order->getOrderIncomeTotal($order->id),
            ];
        }

        $resultArray = $this->processCarts($carts);

        $existingLabels = array_column($resultArray, 'label');
        foreach ($ukrainian_months as $month) {
            if (!in_array($month, $existingLabels)) {
                $resultArray[] = [
                    "label" => "$month",
                    "value" => 0
                ];
            }
        }

        $resultArray = $this->sortByMonths($resultArray);

        return $this->render('income-statistics', ['resultArray' => json_encode($resultArray)]);
    }

}