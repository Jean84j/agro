<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "np_areas".
 *
 * @property int $id
 * @property string|null $ref
 * @property string|null $areasCenter
 * @property string|null $description
 */
class NpAreas extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'np_areas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref', 'areasCenter', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ref' => Yii::t('app', 'Ref'),
            'areasCenter' => Yii::t('app', 'Areas Center'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
