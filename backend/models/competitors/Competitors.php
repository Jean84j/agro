<?php

namespace backend\models\competitors;

use common\models\shop\Product;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "competitors".
 *
 * @property int $id
 * @property int|null $product_id
 */
class Competitors extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'competitors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'default', 'value' => null],
            [['product_id'], 'integer'],
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
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getPriceCompetitor($product_id, $name)
    {

        $price = CompetitorPrice::find()
            ->select('price')
            ->where(['product_id' => $product_id])
            ->andWhere(['name' => $name])
            ->scalar();

        return $price ?: '❌';
    }

}
