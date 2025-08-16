<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property string|null $platform
 * @property string|null $number_order
 * @property string|null $date_order
 * @property string|null $date_delivery
 * @property string|null $number_order_1c
 * @property string|null $date_payment
 * @property int|null $price_delivery
 * @property int|null $nova_pay
 * @property string|null $type_payment
 * @property string|null $fio
 * @property string|null $tel_number
 * @property string|null $address
 * @property string|null $comments
 * @property string|null $delivery_service
 * @property string|null $ttn
 * @property string|null $order_status_id
 * @property string|null $order_pay_ment_id
 */
class Report extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number_order', 'platform', 'date_order'], 'required'],
            [['number_order'], 'unique'],
            [['order_status_id', 'order_pay_ment_id'], 'string', 'max' => 20],
            [['price_delivery', 'nova_pay'], 'number'],
            [['platform', 'number_order', 'date_order', 'date_delivery', 'number_order_1c', 'date_payment', 'type_payment', 'delivery_service'], 'string', 'max' => 50],
            [['fio', 'address', 'comments'], 'string', 'max' => 255],
            [['tel_number'], 'string', 'max' => 20],
            [['ttn'], 'string', 'max' => 100],
            ['tel_number', 'match', 'pattern' => '/^\+38\(\d{3}\)\d{3} \d{4}$/', 'message' => 'Номер не корректный.'],
        ];
    }

    /**
     * Gets query for [[ReportItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReportItems()
    {
        return $this->hasMany(ReportItem::class, ['order_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'platform' => Yii::t('app', 'Platform'),
            'number_order' => Yii::t('app', 'Number Order'),
            'date_order' => Yii::t('app', 'Date Order'),
            'date_delivery' => Yii::t('app', 'Date Delivery'),
            'number_order_1c' => Yii::t('app', 'Number Order 1c'),
            'date_payment' => Yii::t('app', 'Date Payment'),
            'price_delivery' => Yii::t('app', 'Price Delivery'),
            'type_payment' => Yii::t('app', 'Type Payment'),
            'fio' => Yii::t('app', 'Fio'),
            'tel_number' => Yii::t('app', 'Tel Number'),
            'address' => Yii::t('app', 'Address'),
            'comments' => Yii::t('app', 'Comments'),
            'delivery_service' => Yii::t('app', 'Delivery Service'),
            'ttn' => Yii::t('app', 'Ttn'),
            'order_status_id' => Yii::t('app', 'Order Status ID'),
            'order_pay_ment_id' => Yii::t('app', 'Order Pay Ment ID'),
            'nova_pay' => Yii::t('app', 'NovaPay'),
        ];
    }

    public function getTotalSumm($report_id)
    {
        $order = Report::find()->with('reportItems')->where(['id' => $report_id])->one();

        if (in_array($order->order_status_id, ['Повернення', 'Відміна'], true)) {
            return $order->price_delivery ? -$order->price_delivery : 0;
        }

        return array_reduce($order->reportItems, function ($total, $item) {
            return $total + ($item->price * $item->quantity - ($item->discount > 0 ? $item->discount : 0));
        }, 0);
    }


    public function getGoodsName($id)
    {
        $names = ReportItem::find()->select('product_name')->where(['order_id' => $id])->column();

        if ($names) {
            return implode(',  ', $names);
        }
        return null;
    }

    public function getTotalSumPeriod($report_id)
    {
        $order = Report::find()->with('reportItems')->where(['id' => $report_id])->one();
        $total_res = [];
        foreach ($order->reportItems as $orderItem) {
            $total_res[] = $orderItem->price * $orderItem->quantity;
        }
        return array_sum($total_res);
    }

    public function getTotalSumView($report_id)
    {
        $order = Report::find()->with('reportItems')->where(['id' => $report_id])->one();
        $total_res = [];
        foreach ($order->reportItems as $orderItem) {
            $total_res[] = $orderItem->price * $orderItem->quantity;
        }
        return array_sum($total_res);
    }

    public function getCountOrders($phone)
    {
        if ($phone) {
            return Report::find()->where(['tel_number' => $phone])->count();
        }
        return 1;
    }

    public function getStatusOrdersView($phone): array
    {
        return Report::find()->select(['id', 'date_order', 'order_status_id', 'order_pay_ment_id',])
            ->where(['tel_number' => $phone])
            ->orderBy(['date_order' => SORT_DESC])
            ->asArray()
            ->all();
    }

    public function getExecutionStatus($order_status): string
    {
        switch ($order_status) {

            case 'Доставляється':
                $status = '<span class="badge me-2" style="background-color: rgba(249,115,4,0.84)">' . $order_status . '</span>';
                break;
            case 'Відміна':
                $status = '<span class="badge me-2" style="background-color: rgba(79,76,76,0.47)">' . $order_status . '</span>';
                break;
            case 'Повернення':
                $status = '<span class="badge me-2" style="background-color: rgba(255,0,0,0.67)">' . $order_status . '</span>';
                break;
            case 'Комплектується':
                $status = '<span class="badge badge-sa-warning me-2">' . $order_status . '</span>';
                break;
            case 'Одержано':
                $status = '<span class="badge badge-sa-success me-2">' . $order_status . '</span>';
                break;
            case 'Очікується':
                $status = '<span class="badge badge-sa-info me-2">' . $order_status . '</span>';
                break;
            default;
                $status = '<span class="badge badge-sa-dark me-2">' . 'Відсутній' . '</span>';
                break;
        }

        return $status;
    }

    public function getPayMentStatus($order_status): string
    {
        switch ($order_status) {

            case 'Не оплачено':
                $status = '<span class="badge me-2" style="background-color: rgba(249,115,4,0.84)">' . $order_status . '</span>';
                break;
            case 'Оплачено':
                $status = '<span class="badge badge-sa-success me-2">' . $order_status . '</span>';
                break;
            case 'Повернення':
                $status = '<span class="badge me-2" style="background-color: rgba(255,0,0,0.67)">' . $order_status . '</span>';
                break;
            case 'Відміна':
                $status = '<span class="badge me-2" style="background-color: rgba(79,76,76,0.47)">' . $order_status . '</span>';
                break;
            default;
                $status = '<span class="badge badge-sa-dark me-2">' . 'Відсутній' . '</span>';
                break;
        }

        return $status;
    }

    public function getPackage($id): string
    {
        $query = ReportItem::find()->select('package')->where(['order_id' => $id]);
        $packages = $query->column();

        $uniquePackages = array_unique($packages);
        $count = count($uniquePackages);

        if ($count === 1) {
            return $uniquePackages[0] == 'BIG' ? 'Фермерська' : 'Дрібна';
        } else {
            return 'Фермерська + Дрібна';
        }
    }

    public function getPackageForView($package)
    {
        $big = '<svg width="32px" height="32px">
                                                        <use xlink:href="/images/sprite.svg#tractor"></use>
                                                    </svg>';
        $small = '<svg width="28px" height="28px">
                                                        <use xlink:href="/images/sprite.svg#vily"></use>
                                                    </svg>';
        return $package == 'BIG' ? $big : $small;
    }

    public function getDeliveryLogo($delivery_name)
    {
        switch ($delivery_name) {

            case 'Нова Пошта':
                $status = '<svg width="32px" height="32px">
                                                        <use xlink:href="/images/sprite.svg#novaposhta"></use>
                                                    </svg>';
                break;
            case 'УкрПошта':
                $status = '<svg width="32px" height="32px">
                                                        <use xlink:href="/images/sprite.svg#ukrposhta"></use>
                                                    </svg>';
                break;
            case 'Самовивіз':
                $status = '<svg width="32px" height="32px">
                                                        <use xlink:href="/images/sprite.svg#delivery-48"
                                                             style="fill: #47991f;"></use>
                                                    </svg>';
                break;
            default;
                $status = '<i class="far fa-times-circle" style="font-size: 22px"></i>';
                break;
        }
        return $status;
    }

    public function getCountItemsOrder($id)
    {
        $items = ReportItem::find()->where(['order_id' => $id])->count();
        if ($items != 0) {
            return $items;
        } else {
            return 0;
        }
    }

    public function getItemsDiscount($id)
    {
        $discounts = ReportItem::find()->select('discount')->where(['order_id' => $id])->column();
        if ($discounts) {
            return array_sum($discounts);
        } else {
            return 0;
        }
    }

    public function getItemsPlatformPrice($id)
    {
        $platforms = ReportItem::find()->select('platform_price')->where(['order_id' => $id])->column();
        if ($platforms) {
            return array_sum($platforms);
        } else {
            return 0;
        }
    }

    public function getItemsIncomingPrice($id)
    {
        $incomingsSum = [];
        $incomings = ReportItem::find()->select(['entry_price', 'quantity'])->where(['order_id' => $id])->asArray()->all();
        if ($incomings) {
            foreach ($incomings as $incoming) {
                if ($incoming['entry_price']) {
                    $incomingsSum[] = $incoming['entry_price'] * $incoming['quantity'];
                }
            }
            return array_sum($incomingsSum);
        } else {
            return 0;
        }
    }

    public function getPhoneCut($phone)
    {
        if ($phone) {
            $cleanedPhoneNumber = preg_replace('/\D/', '', $phone);

            return substr($cleanedPhoneNumber, 2);
        }
        return '';
    }

    // Assistant
    static public function StatusDeliveryNotSelected()
    {
        $orderNumbers = Report::find()
            ->select('number_order')
            ->where(['or', ['order_status_id' => null], ['order_status_id' => '']])
            ->andWhere(['not in', 'order_status_id', ['Очікується']])
            ->column();
        if ($orderNumbers) {
            return implode('      ', $orderNumbers);
        }
        return null;
    }

    static public function StatusPaymentNotSelected()
    {
        $orderNumbers = Report::find()
            ->select('number_order')
            ->where(['or', ['order_pay_ment_id' => null], ['order_pay_ment_id' => '']])
            ->andWhere(['not in', 'order_status_id', ['Очікується']])
            ->column();
        if ($orderNumbers) {
            return implode('      ', $orderNumbers);
        }
        return null;
    }

    static public function IncomingPriceNotSelected()
    {
        $orderIds = ReportItem::find()
            ->select('order_id')
            ->where(['or',
                ['entry_price' => null], ['entry_price' => '']])
            ->column();

        $orderIds = array_unique($orderIds);

        $orderNumbers = Report::find()
            ->select('number_order')
            ->where(['id' => $orderIds])
            ->andWhere(['not in', 'order_status_id', ['Відміна', 'Повернення', 'Очікується']])
            ->andWhere(['not in', 'order_pay_ment_id', ['Відміна', 'Повернення']])
            ->column();

        if ($orderNumbers) {
            return implode('      ', $orderNumbers);
        }
        return null;
    }

    static public function TtnNot()
    {
        $orderNumbers = Report::find()
            ->select('number_order')
            ->where(['order_status_id' => 'Доставляється'])
            ->andWhere(['or', ['ttn' => null], ['ttn' => '']])
            ->column();
        if ($orderNumbers) {
            return implode('      ', $orderNumbers);
        }
        return null;
    }

    static public function NunberNot()
    {
        $orderNumbers = Report::find()
            ->select('id')
            ->where(['or', ['number_order' => null], ['number_order' => '']])
            ->andWhere(['not in', 'order_status_id', ['Очікується']])
            ->column();
        if ($orderNumbers) {
            return 'ID = ' . implode('      ', $orderNumbers);
        }
        return null;
    }

    static public function DatePaymentNot()
    {
        $orderNumbers = Report::find()
            ->select('number_order')
            ->where(['order_pay_ment_id' => 'Оплачено'])
            ->andWhere(['or', ['date_payment' => null], ['date_payment' => '']])
            ->andWhere(['not in', 'order_status_id', ['Очікується']])
            ->column();
        if ($orderNumbers) {
            return implode('      ', $orderNumbers);
        }
        return null;
    }

    static public function TypePaymentNot()
    {
        $orderNumbers = Report::find()
            ->select('number_order')
            ->where(['order_pay_ment_id' => 'Оплачено'])
            ->andWhere(['or', ['type_payment' => null], ['type_payment' => '']])
            ->andWhere(['not in', 'order_status_id', ['Очікується']])
            ->column();
        if ($orderNumbers) {
            return implode('      ', $orderNumbers);
        }
        return null;
    }

    static public function StatusUnpaidMonth()
    {
        $oneMonthAgo = (new \DateTime())->modify('-1 month')->format('Y-m-d H:i:s');

        $orderNumbers = Report::find()
            ->select('number_order')
            ->where(['order_pay_ment_id' => 'Не оплачено'])
            ->andWhere(['<', 'date_order', $oneMonthAgo])
            ->andWhere(['not in', 'order_status_id', ['Очікується']])
            ->column();

        if ($orderNumbers) {
            return implode('      ', $orderNumbers);
        }
        return null;
    }

    static public function NonNovaPay()
    {
        $orderNumbers = Report::find()
            ->select('number_order')
            ->where(['delivery_service' => 'Нова Пошта'])
            ->andWhere(['type_payment' => 'Nova Pay'])
            ->andWhere(['order_pay_ment_id' => 'Оплачено'])
            ->andWhere(['nova_pay' => null])
            ->andWhere(['not in', 'order_status_id', ['Очікується']])
            ->column();

        if ($orderNumbers) {
            return implode('      ', $orderNumbers);
        }
        return null;
    }

}
