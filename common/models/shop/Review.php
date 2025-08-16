<?php

namespace common\models\shop;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $viewed Перегляд
 * @property int|null $product_id Товар
 * @property int|null $created_at Дата публікації
 * @property float|null $rating Рейтинг
 * @property string|null $name Імя
 * @property string|null $email Email
 * @property string|null $message Текст
 * @property string|null $respond_message Текст
 */
class Review extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'created_at', 'viewed'], 'integer'],
            [['rating'], 'number'],
            [['name', 'email', 'message'], 'string', 'max' => 255],
            [['respond_message'], 'string'],
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
            'rating' => 'Rating',
            'name' => 'Name',
            'email' => 'Email',
            'message' => 'Message',
            'viewed' => 'Viewed',
            'created_at' => 'Date'
        ];
    }

    public function getProductName($id)
    {

        $products = Product::find()->where(['id' => $id])->one();

        return $products->name;
    }

    public function getProductSlug($id)
    {

        $products = Product::find()->where(['id' => $id])->one();

        return $products->slug;
    }

    public function getProductImage($id)
    {
        $products = ProductImage::find()->select('extra_small')->where(['product_id' => $id])->one();

        if ($products !== null){

        return $products->extra_small;

        }else{

            return 'no-image.png';
        }

    }

    public function getReviewRating($rating)
    {
        return $rating / 5;
    }

//  новие отзивы меню админ
    public static function reviewsNews()
    {
        return Review::find()->where(['viewed' => 0])->count();
    }


//  звездочки вместо цифр админ отзивы
    public function getStarRating($rating)
    {
        $stars = '';
        for ($i = 0; $i < $rating; $i++) {
            $stars .= '<svg style="color: #e9a70e" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
        </svg> ';
        }
        return $stars;
    }

    function getAvatar($id)
    {
        $dir = Yii::getAlias('@frontendWeb/images/avatars/');
        $review = Review::find()->where(['id' => $id])->one();
        if ($review){
            $firstLetter = mb_strtolower(mb_substr($review->name, 0, 1, 'UTF-8'));
            if (file_exists($dir . $firstLetter .'.jpg')){
                return $firstLetter;
            }
        }
        return 'no';
    }

}
