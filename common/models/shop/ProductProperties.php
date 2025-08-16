<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_properties".
 *
 * @property int $id
 * @property int $category_id
 * @property int $property_id
 * @property int|null $product_id ID Продукта
 * @property string|null $value Значення
 */
class ProductProperties extends ActiveRecord
{

    public $property_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id', 'property_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'ID Продукта'),
            'value' => Yii::t('app', 'Значення'),
            'category_id' => Yii::t('app', 'ID Категории'),
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(ProductPropertiesTranslate::class, ['property_id' => 'id']);
    }

    public function getTranslation($language)
    {
        return $this->hasOne(ProductPropertiesTranslate::class, ['property_id' => 'id'])->where(['language' => $language]);
    }
}
