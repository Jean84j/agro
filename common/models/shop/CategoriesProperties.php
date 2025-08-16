<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categories_properties".
 *
 * @property int $category_id
 * @property int $property_id
 */
class CategoriesProperties extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories_properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'property_id'], 'required'],
            [['category_id', 'property_id'], 'integer'],
            [['category_id', 'property_id'], 'unique', 'targetAttribute' => ['category_id', 'property_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('app', 'Category ID'),
            'property_id' => Yii::t('app', 'Property ID'),
        ];
    }
}
