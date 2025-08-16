<?php

namespace common\models\shop;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_status".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Order[] $orders
 */
class OrderStatus extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['order_status_id' => 'id']);
    }
}
