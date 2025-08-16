<?php

namespace backend\widgets;

use common\models\shop\Order;
use yii\base\Widget;

class RecentOrders extends Widget
{
    public function init() {

        parent::init();

    }

    public function run() {

        $orders = Order::find()->select(['id', 'fio', 'created_at'])->orderBy('id DESC')->limit(15)->all();

        return $this->render('recent-orders', ['orders' => $orders]);
    }
}