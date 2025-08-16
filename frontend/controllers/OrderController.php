<?php

namespace frontend\controllers;

use common\models\shop\OrderItem;
use common\models\shop\Order;
use yii\helpers\ArrayHelper;
use common\models\NpAreas;
use common\models\Contact;
use yii\web\Controller;
use Yii;

class OrderController extends Controller
{
    public function actionCheckout()
    {
        $item_cart = Yii::$app->cart->getPositions();
        if ($item_cart) {
            $order = new Order();
            if ($order->load($this->request->post()) && $order->save()) {

                if ($order->area) {
                    $area = $order->getNameArea($order->area);
                    if ($area) {
                        $order->area = $area;
                    }
                    $city = $order->getNameCity($order->city);
                    if ($city) {
                        $order->city = $city;
                    }
                    $warehouse = $order->getNameWarehouse($order->warehouses);
                    if ($warehouse) {
                        $order->warehouses = $warehouse;
                    }
                    $order->save();
                }

                if ($order->ukrIndex) {
                    $order->warehouses = $order->ukrIndex;
                    $order->city = $order->ukrCity;

                    $order->save();
                }

                foreach (Yii::$app->cart->getPositions() as $order_cart) {
                    $order_item = new OrderItem();
                    $order_item->order_id = $order->id;
                    $order_item->product_id = $order_cart->id;
                    $order_item->price = $order_cart->getPrice();
                    $order_item->quantity = strval($order_cart->quantity);
                    if ($order_item->save()) {
                    }
                }
                Yii::$app->cart->removeAll();
                Yii::$app->session->set('order_id', $order->id);
                return $this->redirect(['order-success']);
            }

            $areas = ArrayHelper::map(NpAreas::find()
                ->where(['not in', 'description', ['АРК', 'Луганська']])
                ->asArray()
                ->all(), 'ref', 'description');

            $contacts = Contact::find()->one();
            return $this->render('checkout', [
                'contacts' => $contacts,
                'order' => $order,
                'areas' => $areas,
                'orders' => Yii::$app->cart->getPositions(),
                'total_summ' => Yii::$app->cart->getCost(),
                'qty_cart' => Yii::$app->cart->getCount(),
            ]);
        } else {
            return $this->redirect(['/']);
        }
    }

    public function actionOrderSuccess()
    {
        $order_id = Yii::$app->session->get('order_id');
        $order = Order::find()->with('orderItems')->where(['id' => $order_id])->one();

        if (strpos($order->fio, '*') !== false) {
            $order->fio = str_replace('*', 'x', $order->fio);
        }
        if (strpos($order->note, '*') !== false) {
            $order->note = str_replace('*', 'x', $order->note);
        }

        if (!$order->sent_message) {
            $chat_id = 6086317334;
            $this->getSendTelegramMessage($chat_id, $order);
            $order->sent_message = true;
            $order->save();
        } else {

            return $this->redirect(['/']);
        }

        return $this->render('order-success', ['order' => $order]);
    }

    protected function getSendTelegramMessage($chat_id, $order)
    {
        // Основная информация о заказе
        if ($order->area){
            $message = "Нове замовлення AgroPro: * #{$order->id}*\n" .
                "==================================\n" .
                "піб:      *{$order->fio}*\n" .
                "телефон:  *{$order->phone}*\n" .
                "область:  *{$order->area}*\n" .
                "місто:    *{$order->city}*\n" .
                "відділ.:  *{$order->warehouses}*\n" .
                "коментар: *{$order->note}*\n" .
                "--------------------------------------------------------------------\n";
        }elseif ($order->warehouses){
            $message = "Нове замовлення AgroPro: * #{$order->id}*\n" .
                "==================================\n" .
                "піб:      *{$order->fio}*\n" .
                "телефон:  *{$order->phone}*\n" .
                "індекс:  *{$order->warehouses}*\n" .
                "місто:    *{$order->city}*\n" .
                "коментар: *{$order->note}*\n" .
                "--------------------------------------------------------------------\n";
        }else{
            $message = "Нове замовлення AgroPro: * #{$order->id}*\n" .
                "==================================\n" .
                "піб:      *{$order->fio}*\n" .
                "телефон:  *{$order->phone}*\n" .
                "коментар: *{$order->note}*\n" .
                "--------------------------------------------------------------------\n";
        }

        foreach ($order->orderItems as $item) {
            $message .= "*{$item->getProductName($item->product->id)}* " .
                " | К-ть: *{$item->quantity}* " .
                " | Ціна: *{$item->price}* \n" .
                "--------------------------------------------------------------------\n";
        }
        $message .= "Загальна Сума : *" . Yii::$app->formatter->asCurrency($order->getTotalSumm($order->id)) . "*\n" .

            "==================================\n";
        // Отправка сообщения в Telegram
        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);
    }

    public function actionConditions()
    {
        return $this->render('conditions');
    }

}