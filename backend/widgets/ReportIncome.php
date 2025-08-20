<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use backend\models\Report;
use backend\models\ReportItem;
use DateInterval;
use DateTime;

class ReportIncome extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $currentDate = new DateTime();
        $lastYearDate = $currentDate->sub(new DateInterval('P12M'))->format('Y-m-d');

        $orders = Report::find()
            ->where(['order_pay_ment_id' => 'Оплачено'])
            ->andWhere(['>=', 'date_order', $lastYearDate])
            ->all();

        $carts = [];
        $ukrainian_months = $this->getUkrainianMonths();

        foreach ($orders as $order) {
            $month_name = date('M', strtotime($order->date_order));
            $ukrainian_month_name = $ukrainian_months[$month_name] ?? '';

            $orderItems = ReportItem::find()->where(['order_id' => $order->id])->all();
            $total_res = [];
            foreach ($orderItems as $orderItem) {
                $total_res[] = intval($orderItem->price * $orderItem->quantity);
            }
            $sum = array_sum($total_res);

            $carts[] = [
                "label" => $ukrainian_month_name,
                "value" => $sum,
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