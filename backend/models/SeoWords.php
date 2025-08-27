<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "seo_words".
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $product_id
 * @property string|null $uk_word
 * @property string|null $ru_word
 * @property int|null $visible
 */
class SeoWords extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_words';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'product_id', 'uk_word', 'ru_word'], 'default', 'value' => null],
            [['visible'], 'default', 'value' => 1],
            [['category_id', 'product_id', 'visible'], 'integer'],
            [['uk_word', 'ru_word'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'product_id' => 'Product ID',
            'uk_word' => 'Uk Word',
            'ru_word' => 'Ru Word',
            'visible' => 'Visible',
        ];
    }

}
