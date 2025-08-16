<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_products".
 *

 * @property int|null $post_id
 * @property int|null $product_id
 */
class PostProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => Yii::t('app', 'Post ID'),
            'product_id' => Yii::t('app', 'Product ID'),
        ];
    }
}
