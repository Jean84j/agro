<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_grup".
 *
 * @property int|null $product_id ID продукту
 * @property int|null $grup_id ID групи
 */
class ProductGrup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_grup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'grup_id'], 'required'],
            [['product_id', 'grup_id'], 'integer'],
            [['product_id', 'grup_id'], 'unique', 'targetAttribute' => ['product_id', 'grup_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['grup_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grup::class, 'targetAttribute' => ['grup_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'ID продукту'),
            'grup_id' => Yii::t('app', 'ID групи'),
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Grup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrup()
    {
        return $this->hasOne(Grup::class, ['id' => 'grup_id']);
    }
}
