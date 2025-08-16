<?php

namespace common\models\shop;

use Yii;
use common\models\NpAreas;
use common\models\NpCity;
use common\models\NpWarehouses;
use common\models\OrderPayMent;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $created_at Дата створення
 * @property int|null $updated_at Дата оновлення
 * @property int|null $order_status_id Статус
 * @property int|null $order_pay_ment_id Статус оплати
 * @property int|null $order_provider_id Постачальник
 * @property string|null $fio ПІБ
 * @property string|null $phone Телефон
 * @property string|null $city Город
 * @property string|null $note Примітка
 * @property string|null $area Область
 * @property string|null $warehouses Відділення
 * @property string|null $comment Примітка менеджера
 * @property boolean|false $sent_message Повідомлення
 *
 * @property OrderItem[] $orderItems
 * @property OrderStatus $orderStatus
 * @property OrderPayMent $orderPayMent
 * @property OrderProvider $orderProvider
 */
class Order extends ActiveRecord
{
    public $ukrIndex;
    public $ukrCity;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['ukrIndex', 'match', 'pattern' => '/^\d{5}$/', 'message' => 'Індекс повинен містити 5 цифр.'],
            ['ukrCity', 'string', 'max' => 40],
            [['fio', 'phone'], 'required'],
            [['sent_message'], 'boolean'],
            [['created_at', 'updated_at', 'order_status_id', 'order_pay_ment_id', 'order_provider_id'], 'integer'],
            [['fio', 'phone', 'city', 'area', 'warehouses'], 'string', 'max' => 255],
            [['note', 'comment'], 'string'],
            [['order_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::class, 'targetAttribute' => ['order_status_id' => 'id']],
            [['order_pay_ment_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderPayMent::class, 'targetAttribute' => ['order_pay_ment_id' => 'id']],
            ['phone', 'match', 'pattern' => '/^\+38\(\d{3}\)\d{3} \d{4}$/', 'message' => 'Номер не корректный.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата створення',
            'updated_at' => 'Дата оновлення',
            'order_status_id' => 'Статус',
            'order_pay_ment_id' => 'Статус оплати',
            'fio' => 'ПІБ',
            'phone' => 'Телефон',
            'city' => 'Місто',
            'note' => 'Коментар (не обов’язково)',
            'order_provider_id' => 'Постачальник',
            'comment' => 'Коментар менеджера',
            'sent_message' => 'Повідомлення менеджеру',
            'area' => 'Область',
            'warehouses' => 'Відділення',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[OrderStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::class, ['id' => 'order_status_id']);
    }

    public function getOrderProvider()
    {
        return $this->hasOne(OrderProvider::class, ['id' => 'order_provider_id']);
    }

    public function getOrderPayMent()
    {
        return $this->hasOne(OrderPayMent::class, ['id' => 'order_pay_ment_id']);
    }

    public function getTotalSumm($order_id)
    {
        $order = Order::find()->with('orderItems')->where(['id' => $order_id])->one();
        $total_res = [];
        foreach ($order->orderItems as $orderItem) {
            $total_res[] = $orderItem->price * $orderItem->quantity;
        }
        return array_sum($total_res);
    }

    public function getTotalQty($order_id)
    {
        $order = Order::find()->with('orderItems')->where(['id' => $order_id])->one();
        $total_res = [];
        foreach ($order->orderItems as $orderItem) {
            $total_res[] = $orderItem->quantity;
        }
        return array_sum($total_res);
    }

    public function getPayMent($order_id)
    {
        $order = Order::find()->with('orderPayMent')->where(['id' => $order_id])->one();
        $status = '<span class="badge badge-sa-dark me-2">Не відомо</span>';
        if ($order->order_pay_ment_id != null) {
            switch ($order->order_pay_ment_id) {
                case 1:
                    $status = '<span class="badge badge-sa-danger me-2">' . $order->orderPayMent->name . '</span>';
                    break;
                case 2:
                    $status = '<span class="badge badge-sa-warning me-2">' . $order->orderPayMent->name . '</span>';
                    break;
                case 3:
                    $status = '<span class="badge badge-sa-success me-2">' . $order->orderPayMent->name . '</span>';
                    break;
                case 4:
                    $status = '<span class="badge me-2" style="background-color: rgba(188,177,177,0.93)">' . $order->orderPayMent->name . '</span>';
                    break;
                case 5:
                    $status = '<span class="badge me-2" style="background-color: rgba(215,36,30,0.56)">' . $order->orderPayMent->name . '</span>';
                    break;
                default;
                    $status = '<span class="badge badge-sa-dark me-2">' . $order->orderPayMent->name . '</span>';
                    break;
            }
        }
        return $status;
    }

    public function getExecutionStatus($order_id)
    {
        $order = Order::find()->with('orderStatus')->where(['id' => $order_id])->one();
        $status = '<span class="badge badge-sa-primary me-2"> Новий <i class="fas fa-exclamation"> </i> <i class="fas fa-exclamation"> </i> <i class="fas fa-exclamation"> </i></span>';
        if ($order->order_status_id != null) {
            switch ($order->order_status_id) {
                case 1:
                    $status = '<span class="badge badge-sa-info me-2">' . $order->orderStatus->name . '</span>';
                    break;
                case 2:
                    $status = '<span class="badge badge-sa-warning me-2">' . $order->orderStatus->name . '</span>';
                    break;
                case 3:
                    $status = '<span class="badge badge-sa-success me-2">' . $order->orderStatus->name . '</span>';
                    break;
                case 4:
                    $status = '<span class="badge me-2" style="background-color: rgba(215,36,30,0.56)">' . $order->orderStatus->name . '</span>';
                    break;
                case 5:
                    $status = '<span class="badge me-2" style="background-color: rgba(188,177,177,0.93)">' . $order->orderStatus->name . '</span>';
                    break;
                case 6:
                    $status = '<span class="badge me-2" style="background-color: rgba(249,115,4,0.84)">' . $order->orderStatus->name . '</span>';
                    break;
                default;
                    $status = '<span class="badge badge-sa-dark me-2">' . $order->orderStatus->name . '</span>';
                    break;
            }
        }
        return $status;
    }

    public function getOrderIncomeTotal($order_id)
    {
        $order = Order::find()->with('orderItems')->where(['id' => $order_id])->one();
        $total_res = [];
        foreach ($order->orderItems as $orderItem) {
            $total_res[] = intval($orderItem->price * $orderItem->quantity);
        }
        return array_sum($total_res);
    }

    public function getProvider($id)
    {
        if ($id != null) {
            $order = OrderProvider::find()->where(['id' => $id])->one();
            if ($order != null) {

                return $order->name;

            } else {

                return $order = 'Видалений';
            }
        } else {

            return $order = 'Не вибрано';
        }
    }

//  новый заказ в меню админ
    public static function orderNews()
    {
        return Order::find()->where(['order_status_id' => null])->count();
    }

//  Нова почта
    public function getNameArea($ref)
    {
        $area = NpAreas::find()->select('description')->where(['ref' => $ref])->one();
        if ($area) {
            return $area->description;
        } else {
            return '';
        }
    }

    public function getNameCity($ref)
    {
        $city = NpCity::find()->select('description')->where(['ref' => $ref])->one();
        if ($city) {
            return $city->description;
        } else {
            return '';
        }
    }

    public function getNameWarehouse($ref)
    {
        $warehouse = NpWarehouses::find()->select('description')->where(['ref' => $ref])->one();
        if ($warehouse) {
            return $warehouse->description;
        } else {
            return '';
        }
    }
    
    // 64 * 64
    public
    function getImgOneExtraSmal($id)
    {
        $webp_support = ProductImage::imageWebp();
        $product = Product::find()->with('images')->where(['id' => $id])->one();

        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);

        if (isset($images[0])) {
            if ($webp_support == true && isset($images[0]->webp_extra_small)) {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->webp_extra_small;
            } else {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->extra_small;
            }
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }
    
}