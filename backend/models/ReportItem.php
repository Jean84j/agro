<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "report_item".
 *
 * @property int $id
 * @property int|null $order_id
 * @property string|null $product_name
 * @property int|null $price
 * @property string|null $volume
 * @property string|null $unit
 * @property string|null $package
 * @property int|null $quantity
 * @property int|null $kurs
 * @property int|null $entry_price
 * @property int|null $platform_price
 * @property int|null $discount
 */
class ReportItem extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'quantity'], 'integer'],
            [['platform_price', 'price', 'kurs', 'entry_price', 'discount'], 'number'],
            [['product_name'], 'string', 'max' => 255],
            [['volume'], 'string', 'max' => 10],
            [['unit'], 'string', 'max' => 20],
            [['package'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'product_name' => Yii::t('app', 'Product Name'),
            'price' => Yii::t('app', 'Price'),
            'volume' => Yii::t('app', 'Volume'),
            'unit' => Yii::t('app', 'Unit'),
            'quantity' => Yii::t('app', 'Quantity'),
            'kurs' => Yii::t('app', 'Kurs'),
            'entry_price' => Yii::t('app', 'Entry Price'),
            'platform_price' => Yii::t('app', 'Platform Price'),
            'discount' => Yii::t('app', 'Discount'),
            'package' => Yii::t('app', 'Package'),
        ];
    }
}
