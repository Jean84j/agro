<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_image".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $name
 *
 * @property string|null $extra_extra_large
 * @property string|null $extra_large
 * @property string|null $large
 * @property string|null $medium
 * @property string|null $small
 * @property string|null $extra_small
 * @property string|null $alt
 * @property int|null $priority
 */
class ProductImage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'priority'], 'integer'],
            [['name', 'alt', 'extra_extra_large', 'extra_large', 'large', 'medium', 'small', 'extra_small'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'name' => Yii::t('app', 'Name'),
            'alt' => Yii::t('app', 'Alt'),
            'priority' => Yii::t('app', 'Priority'),
        ];
    }

    public static function imageWebp()
    {
        if (isset($_SERVER['HTTP_ACCEPT']) && isset($_SERVER['HTTP_USER_AGENT'])) {
            if (strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/') !== false) {
                $webp_support = true; // webp поддерживается
            } else {
                $webp_support = false; // webp не поддерживается
            }
        } else {
            $webp_support = false; // webp не поддерживается (или установите значение по умолчанию)
        }
        return $webp_support;
    }
}
