<?php

namespace backend\models\competitors;

use common\models\shop\Product;

use common\models\shop\ProductImage;
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

        return $price ? number_format((float)$price, 2, '.', '') : '❌';
    }

    public function getImage($id)
    {
        $webp_support = ProductImage::imageWebp();
        $product = Product::find()->with('images')->where(['id' => $id])->one();

        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);

        if (isset($images[0])) {
            if ($webp_support == true && isset($images[0]->webp_extra_small)) {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->webp_extra_small;
            } else {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->extra_small;
            }
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }

}
