<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categories_translate".
 *
 * @property int $id
 * @property string|null $language
 * @property int|null $category_id
 * @property string|null $name
 * @property string|null $pageTitle
 * @property string|null $description
 * @property string|null $metaDescription
 * @property string|null $prefix
 * @property string $keywords
 * @property string $product_keywords
 * @property string $product_footer_description
 * @property string $product_title
 * @property string $product_description
 * @property string $h1
 */
class CategoriesTranslate extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['description', 'product_footer_description', 'h1'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['name', 'pageTitle', 'metaDescription', 'keywords', 'product_keywords', 'product_title', 'product_description'], 'string', 'max' => 255],
            [['prefix'], 'string', 'max' => 50],
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
            'pageTitle' => Yii::t('app', 'Page Title'),
            'description' => Yii::t('app', 'Description'),
            'metaDescription' => Yii::t('app', 'Meta Description'),
            'prefix' => Yii::t('app', 'Prefix'),
        ];
    }
}
