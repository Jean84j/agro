<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "translations".
 *
 * @property int $id
 * @property string|null $category
 * @property string|null $message
 * @property string|null $translation
 * @property string|null $language
 */
class Translations extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'translation'], 'string'],
            [['category'], 'string', 'max' => 10],
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
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
            'translation' => Yii::t('app', 'Translation'),
            'language' => Yii::t('app', 'Language'),
        ];
    }
}
