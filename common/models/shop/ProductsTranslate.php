<?php

namespace common\models\shop;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "products_translate".
 *
 * @property int $id
 * @property string|null $language
 * @property int|null $product_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $short_description
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $footer_description
 * @property string|null $keywords
 * @property string|null $h1
 */
class ProductsTranslate extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['description', 'short_description', 'footer_description', 'keywords'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['name', 'h1', 'seo_title', 'seo_description'], 'string', 'max' => 255],
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
            'product_id' => Yii::t('app', 'Product ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'short_description' => Yii::t('app', 'Short Description'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'footer_description' => Yii::t('app', 'Footer Description'),
        ];
    }

}
