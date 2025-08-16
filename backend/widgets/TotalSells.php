<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\shop\Order;
use common\models\shop\OrderItem;

class TotalSells extends BaseWidgetBackend
{
    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $orders_pay = Order::find()
            ->select('id')
            ->where(['order_pay_ment_id' => 3])
            ->asArray()
            ->all();

        $flatArray = array_map(function ($item) {
            return $item['id'];
        }, $orders_pay);

        $sum = [];
        $orders = OrderItem::find()
            ->where(['order_id' => $flatArray])
            ->all();
        foreach ($orders as $order) {
            $sum[] = $order->price * $order->quantity;
        }
        $sum = array_sum($sum);

        $formattedDate = $this->getPreviousMonthFormatted();

        $DaysAgo30 = strtotime('-30 days');
        $orders = Order::find()
            ->select('id')
            ->where(['order_pay_ment_id' => 3])
            ->andWhere(['>=', 'created_at', $DaysAgo30])
            ->asArray()
            ->all();

        $res_30 = [];
        foreach ($orders as $order) {
            $prices = OrderItem::find()->where(['order_id' => $order['id']])->all();
            foreach ($prices as $price) {
                $res_30[] = $price->price * $price->quantity;
            }
        }
        $res_30 = array_sum($res_30);

        $DaysAgo60 = strtotime('-60 days');
        $orders = Order::find()
            ->select('id')
            ->where(['order_pay_ment_id' => 3])
            ->andWhere(['>=', 'created_at', $DaysAgo60])
            ->asArray()
            ->all();

        $res_60 = [];
        foreach ($orders as $order) {
            $prices = OrderItem::find()->where(['order_id' => $order['id']])->all();
            foreach ($prices as $price) {
                $res_60[] = $price->price * $price->quantity;
            }
        }
        $res_60 = array_sum($res_60);
        $res_60 = $res_60 - $res_30;

        if ($res_30 > $res_60) {
            $arrow = 'up';
        } else {
            $arrow = 'down';
        }

        if ($res_30 != 0) {
            $percentage = (($res_60 - $res_30) / $res_30) * 100;
            $percentage = abs(round($percentage));
        } else {
            $percentage = 1000;
        }

        return $this->render('total-sells', [
            'sum' => $sum,
            'formattedDate' => $formattedDate,
            'arrow' => $arrow,
            'percentage' => $percentage,
            'title' => 'Всього продалося',
        ]);
    }
}