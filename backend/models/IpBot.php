<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "ip_bot".
 *
 * @property int $id
 * @property string|null $ip
 * @property string|null $isp
 * @property int|null $blocking
 * @property string|null $comment
 */
class IpBot extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ip_bot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blocking'], 'integer'],
            [['ip'], 'string', 'max' => 20],
            [['isp', 'comment'], 'string', 'max' => 255],
            [['ip'], 'unique'],
            [['ip', 'isp'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'isp' => 'Isp',
            'blocking' => 'Blocking',
            'comment' => 'Comment',
        ];
    }
}
