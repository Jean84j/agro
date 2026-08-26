<?php

namespace backend\models\competitors;

use Yii;

/**
 * This is the model class for table "competitor_price".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $name
 * @property string|null $url
 * @property float|null $price
 * @property int|null $last_checked_at
 */
class CompetitorPrice extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'competitor_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'name', 'url', 'price', 'last_checked_at'], 'default', 'value' => null],
            [['product_id', 'last_checked_at'], 'integer'],
            [['price'], 'number'],
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'url' => 'Url',
            'price' => 'Price',
            'last_checked_at' => 'Last Checked At',
        ];
    }

}
