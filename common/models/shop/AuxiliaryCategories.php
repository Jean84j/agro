<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auxiliary_categories".
 *
 * @property int $id
 * @property int|null $parentId
 * @property string|null $name
 * @property string|null $pageTitle
 * @property string|null $slug
 * @property string|null $image
 * @property string|null $visibility
 * @property string|null $description
 * @property string|null $metaDescription
 * @property string|null $svg
 * @property string|null $prefix
 * @property string|null $object
 * @property string $date_public Дата публикации
 * @property string $date_updated Дата редактирования
 * @property string $h1
 * @property string $keywords
 */
class AuxiliaryCategories extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => 'name',
                // optional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ],
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',  // создание даты
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_public'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_updated'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auxiliary_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentId'], 'integer'],
            [['description', 'h1'], 'string'],
            [['name', 'pageTitle', 'slug', 'image', 'visibility', 'metaDescription', 'svg', 'prefix',
                'object', 'date_public', 'date_updated', 'keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parentId' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'pageTitle' => Yii::t('app', 'Page Title'),
            'slug' => Yii::t('app', 'Slug'),
            'image' => Yii::t('app', 'Image'),
            'visibility' => Yii::t('app', 'Visibility'),
            'description' => Yii::t('app', 'Description'),
            'metaDescription' => Yii::t('app', 'Meta Description'),
            'svg' => Yii::t('app', 'Svg'),
            'prefix' => Yii::t('app', 'Prefix'),
            'object' => Yii::t('app', 'Object'),
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(AuxiliaryTranslate::class, ['category_id' => 'id']);
    }

    public function getTranslation($language)
    {
        return $this->hasOne(AuxiliaryTranslate::class, ['category_id' => 'id'])->where(['language' => $language]);
    }

    public function getSchemaRatingCategory($productsId)
    {
        $reviews = Review::find()
            ->select('rating')
            ->where(['product_id' => $productsId])
            ->all();
        $res = [];
        foreach ($reviews as $review) {
            $res[] = $review->rating;
        }
        if (count($res) > 0) {
            $average = array_sum($res) / count($res);
            return round($average, 1);
        } else {
            return '4.4';
        }
    }

    public function getSchemaCountReviewsCategory($productsId)
    {
        $reviews = Review::find()
            ->select('id')
            ->where(['product_id' => $productsId])
            ->all();
        $res = [];
        foreach ($reviews as $review) {
            $res[] = $review;
        }
        if (count($res) > 0) {
            return count($res);

        } else {
            return '28';
        }
    }

    public function getCatalogHighPrice($productsId)
    {
        $highPrice = Product::find()
            ->where(['id' => $productsId])
            ->orderBy(['price' => SORT_DESC])
            ->one();

        return $highPrice->price;
    }

    public function getCatalogLowPrice($productsId)
    {
        $lowPrice = Product::find()
            ->where(['id' => $productsId])
            ->orderBy(['price' => SORT_ASC])
            ->one();

        return $lowPrice->price;
    }

    public function getCategopyName($id)
    {
        $category = Category::find()->select('name')->where(['id' => $id])->one();

        return $category->name;
    }

    public function getDateUpdated($timeStamp)
    {
        if ($timeStamp) {
            return Yii::$app->formatter->asDatetime($timeStamp, 'medium');
        } else {
            return '-----';
        }
    }

    /**
     * Вкладки Tab основная информация
     */
    public function getTabs(): array
    {
        return [
            [
                'id' => 'description',
                'icon' => 'fas fa-info-circle',
                'label' => 'Основна інформація',
                'active' => true,
                'view' => '/auxiliary-categories/basic-information',
            ],
            [
                'id' => 'seo',
                'icon' => 'fas fa-search-dollar',
                'label' => 'Просунення в пошуку',
                'view' => '/_partials/seo-information'
            ],
        ];
    }
}
