<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "minimum_order_amount".
 *
 * @property int $id
 * @property float $amount Минимальная сумма заказа
 */
class MinimumOrderAmount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'minimum_order_amount';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amount' => Yii::t('app', 'Amount'),
        ];
    }
}
