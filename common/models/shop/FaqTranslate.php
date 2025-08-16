<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "faq_translate".
 *
 * @property int $id
 * @property int|null $faq_id
 * @property string|null $language
 * @property string|null $question
 * @property string|null $answer
 */
class FaqTranslate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['faq_id'], 'integer'],
            [['question', 'answer'], 'string'],
            [['language'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'faq_id' => Yii::t('app', 'Faq ID'),
            'language' => Yii::t('app', 'Language'),
            'question' => Yii::t('app', 'Question'),
            'answer' => Yii::t('app', 'Answer'),
        ];
    }
}
