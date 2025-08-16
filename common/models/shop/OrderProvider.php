<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_provider".
 *
 * @property int $id
 * @property string|null $name Постачальник
 */
class OrderProvider extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_provider';
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
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Постачальник'),
        ];
    }

    public function getOrders()
    {
        return $this->hasMany(Order::class, ['order_provider_id' => 'id']);
    }
}
