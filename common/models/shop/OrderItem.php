<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property int|null $order_id Інформація про замовлення
 * @property int|null $product_id Товар
 * @property string|null $quantity Кількість
 * @property float|null $price Ціна
 *
 * @property Order $order
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id'], 'integer'],
            [['price'], 'number'],
            [['quantity'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Інформація про замовлення',
            'product_id' => 'Товар',
            'quantity' => 'Кількість',
            'price' => 'Ціна',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getProduct(){
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
