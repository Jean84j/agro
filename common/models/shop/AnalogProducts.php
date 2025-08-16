<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "analog_products".
 *
 * @property int $product_id
 * @property int $analog_product_id
 */
class AnalogProducts extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analog_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'analog_product_id'], 'required'],
            [['product_id', 'analog_product_id'], 'integer'],
            [['product_id', 'analog_product_id'], 'unique', 'targetAttribute' => ['product_id', 'analog_product_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'analog_product_id' => Yii::t('app', 'Analog Product ID'),
        ];
    }
}
