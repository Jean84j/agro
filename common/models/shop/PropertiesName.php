<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * This is the model class for table "properties_name".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $sort
 */
class PropertiesName extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'properties_name';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(PropertiesNameTranslate::class, ['name_id' => 'id']);
    }

    public function getTranslation($language)
    {
        return $this->hasOne(PropertiesNameTranslate::class, ['name_id' => 'id'])->where(['language' => $language]);
    }

    public function getCategoriesProperty($id)
    {
        return Category::find()
            ->select(['GROUP_CONCAT(name SEPARATOR ", ") AS names'])
            ->where(['id' => CategoriesProperties::find()
                ->select('category_id')
                ->where(['property_id' => $id])
            ])
            ->scalar() ?: Html::tag('span', 'Без категории', ['style' => 'color: red; font-weight: bold;']);
    }

    public function getProductCountProperty($id)
    {
        return ProductProperties::find()
            ->where(['property_id' => $id])
            ->count();
    }

}
