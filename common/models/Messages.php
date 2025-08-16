<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string|null $name Имя
 * @property string|null $email Почта
 * @property string|null $subject Тема
 * @property string|null $message Сообщение
 * @property string|null $comment Коментарий менеджера
 * @property int|null $viewed Просмотр
 * @property int|null $created_at Дата создания
 */
class Messages extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'comment'], 'string'],
            [['viewed', 'created_at'], 'integer'],
            [['name', 'email', 'subject'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'subject' => 'Subject',
            'message' => 'Message',
            'comment' => 'Comment',
            'viewed' => 'Viewed',
            'created_at' => 'Date',
        ];
    }
//  новые сообщения в меню админ
    public static function messagesNews()
    {
        return Messages::find()->where(['viewed' => 0])->count();
    }

}
