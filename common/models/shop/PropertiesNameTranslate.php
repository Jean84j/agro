<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "properties_name_translate".
 *
 * @property int $id
 * @property string|null $language
 * @property int|null $name_id
 * @property string|null $name
 */
class PropertiesNameTranslate extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'properties_name_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_id'], 'integer'],
            [['language'], 'string', 'max' => 3],
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
            'language' => Yii::t('app', 'Language'),
            'name_id' => Yii::t('app', 'Name ID'),
            'name' => Yii::t('app', 'Name'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }
}
