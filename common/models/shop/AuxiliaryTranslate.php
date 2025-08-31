<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auxiliary_translate".
 *
 * @property int $id
 * @property string|null $language
 * @property int|null $category_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $pageTitle
 * @property string|null $metaDescription
 * @property string $h1
 * @property string $keywords
 */
class AuxiliaryTranslate extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auxiliary_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['language'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 50],
            [['description', 'h1'], 'string'],
            [['pageTitle', 'metaDescription', 'keywords'], 'string', 'max' => 255],
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
            'category_id' => Yii::t('app', 'Category ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'pageTitle' => Yii::t('app', 'Page Title'),
            'metaDescription' => Yii::t('app', 'Meta Description'),
        ];
    }
}
