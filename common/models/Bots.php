<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "bots".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $comment
 * @property int|null $blocking
 */
class Bots extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blocking'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'comment' => 'Comment',
            'blocking' => 'Blocking',
        ];
    }
}
