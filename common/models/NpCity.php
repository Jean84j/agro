<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "np_city".
 *
 * @property int $id
 * @property boolean|null $city
 * @property string|null $cityID
 * @property string|null $ref
 * @property string|null $area
 * @property string|null $description
 */
class NpCity extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'np_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cityID', 'ref', 'area', 'description'], 'string', 'max' => 255],
            [['city'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'city' => Yii::t('app', 'City'),
            'cityID' => Yii::t('app', 'City ID'),
            'ref' => Yii::t('app', 'Ref'),
            'area' => Yii::t('app', 'Area'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
