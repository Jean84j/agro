<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_properties_translate".
 *
 * @property int $id
 * @property int|null $product_properties_id
 * @property int|null $propertyName_id
 * @property int|null $product_id
 * @property string|null $language
 * @property string|null $value
 */
class ProductPropertiesTranslate extends ActiveRecord
{

    public $property_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_properties_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_properties_id', 'propertyName_id', 'product_id'], 'integer'],
            [['language'], 'string', 'max' => 10],
            [['value'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'language' => Yii::t('app', 'Language'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
