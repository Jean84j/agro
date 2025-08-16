<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property string|null $address Адреса
 * @property string|null $tel_primary Телефон перший
 * @property string|null $tel_second Телефон другий
 * @property string|null $hours_work Години роботи
 * @property string|null $coments Коментар
 * @property string|null $comment_two Коментарій другий
 * @property string|null $work_time_short Години праці короткі
 * @property string|null $email Email
 * @property string $language Мова
 */
class Contact extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_two'], 'string'],
            [['email'], 'email'],
            [['address', 'tel_primary', 'tel_second', 'hours_work', 'coments', 'work_time_short', 'language'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'address' => Yii::t('app', 'Address'),
            'tel_primary' => Yii::t('app', 'Tel Primary'),
            'tel_second' => Yii::t('app', 'Tel Second'),
            'hours_work' => Yii::t('app', 'Hours Work'),
            'coments' => Yii::t('app', 'Coments'),
            'comment_two' => Yii::t('app', 'Comment Two'),
            'work_time_short' => Yii::t('app', 'Work Time Short'),
            'email' => Yii::t('app', 'Email'),
        ];
    }
}
