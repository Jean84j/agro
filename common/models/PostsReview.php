<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "posts_review".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $created_at
 * @property float|null $rating
 * @property string|null $name
 * @property string|null $email
 * @property string|null $message
 * @property int $viewed
 */
class PostsReview extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts_review';
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
            [['post_id', 'created_at'], 'integer'],
            [['rating'], 'number'],
            [['message'], 'string'],
            [['name', 'email', 'viewed'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'rating' => Yii::t('app', 'Rating'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'message' => Yii::t('app', 'Message'),
            'viewed' => Yii::t('app', 'Viewed'),
        ];
    }
    public function getPostName($id)
    {
        $post = Posts::find()->where(['id' => $id])->one();

        return $post->title;
    }
    //  новие отзивы меню админ
    public static function reviewsNews()
    {
        return PostsReview::find()
            ->where(['viewed' => 0])
            ->count();
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
        $review = PostsReview::find()->select('name')->where(['id' => $id])->one();
        if ($review){
            $firstLetter = mb_strtolower(mb_substr($review->name, 0, 1, 'UTF-8'));
            if (file_exists($dir . $firstLetter .'.jpg')){
                return $firstLetter;
            }
        }
        return 'no';
    }
}
