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


    public function getCompetitorPricesMap($productId)
    {
        return CompetitorPrice::find()
            ->select(['price', 'name'])
            ->where(['product_id' => $productId])
            ->indexBy('name')
            ->column();
    }

    public function getCompetitorUrlsMap($productId)
    {
        return CompetitorPrice::find()
            ->select(['url', 'name'])
            ->where(['product_id' => $productId])
            ->indexBy('name')
            ->column();
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


    public static function getHeadCompetitors($name)
    {
        return match ($name) {

            'agroprocvit.com.ua' => [
                'name' => 'Агропроцвіт',
                'image' => Yii::$app->request->hostInfo . '/admin/images/competitors/agroprocvit.png',
            ],
                        'hectare.ua' => [
                'name' => 'Гектар',
                'image' => Yii::$app->request->hostInfo . '/admin/images/competitors/hectar.ico',
            ],
                        'agro-market.net' => [
                'name' => 'АгроМаркет',
                'image' => Yii::$app->request->hostInfo . '/admin/images/competitors/agro-market.png',
            ],
                        'tovpaz.com' => [
                'name' => 'Поділля',
                'image' => Yii::$app->request->hostInfo . '/admin/images/competitors/tovpaz.png',
            ],
                        'agromag.ua' => [
                'name' => 'АгроМаг',
                'image' => Yii::$app->request->hostInfo . '/admin/images/competitors/agro-mag.ico',
            ],
            default => [
                'name' => $name,
                'image' => null,
            ],
        };
    }

}
