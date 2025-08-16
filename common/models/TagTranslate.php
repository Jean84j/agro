<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag_translate".
 *
 * @property int $id
 * @property string|null $language
 * @property int|null $tag_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $seo_title
 * @property string|null $seo_description
 */
class TagTranslate extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_id'], 'integer'],
            [['language'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 50],
            [['description', 'seo_title', 'seo_description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'tag_id' => Yii::t('app', 'Tag ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
