<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "np_warehouses".
 *
 * @property int $id
 * @property string|null $cityRef
 * @property string|null $description
 * @property string|null $shortAddress
 * @property string|null $ref
 * @property int|null $Number
 */
class NpWarehouses extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'np_warehouses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Number'], 'integer'],
            [['cityRef', 'description', 'shortAddress', 'ref'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cityRef' => Yii::t('app', 'City Ref'),
            'description' => Yii::t('app', 'Description'),
            'shortAddress' => Yii::t('app', 'Short Address'),
            'Number' => Yii::t('app', 'Number'),
            'ref' => Yii::t('app', 'Ref'),
        ];
    }
}
