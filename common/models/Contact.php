<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property string|null $address Адреса
 * @property string|null $tel_primary Телефон перший
 * @property string|null $tel_second Телефон другий
 * @property string|null $hours_work Години роботи
 * @property string|null $coments Коментар
 */
class Contact extends \yii\db\ActiveRecord
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
            [['address', 'tel_primary', 'tel_second', 'hours_work', 'coments'], 'string', 'max' => 255],
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
            'tel_primary' => Yii::t('app', 'The phone is the first'),
            'tel_second' => Yii::t('app', 'Phone number two'),
            'hours_work' => Yii::t('app', 'Hours of work'),
            'coments' => Yii::t('app', 'Coment'),
        ];
    }
}
