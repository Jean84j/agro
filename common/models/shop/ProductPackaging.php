<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "product_packaging".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $product_variant_id
 * @property string|null $volume
 */
class ProductPackaging extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_packaging';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'product_variant_id'], 'integer'],
            [['volume'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'product_variant_id' => Yii::t('app', 'Product Variant ID'),
            'volume' => Yii::t('app', 'Volume'),
        ];
    }
}
