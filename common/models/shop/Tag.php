<?php

namespace common\models\shop;

use common\models\TagTranslate;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property int $date_public
 * @property int $date_updated
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $description
 * @property string $seo_title
 * @property string $seo_description
 * @property boolean $visibility
 * @property boolean $h1
 * @property boolean $keywords
 */
class Tag extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

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
                'immutable' => true,
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
    public function rules()
    {
        return [
            [['name', 'slug'], 'string', 'max' => 50],
            [['h1'], 'string', 'max' => 150],
            [['description', 'seo_title', 'seo_description', 'keywords'], 'string'],
            [['date_public', 'date_updated'], 'integer'],
            [['visibility'], 'boolean'],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(TagTranslate::class, ['tag_id' => 'id']);
    }

    public function getTranslation($language)
    {
        return $this->hasOne(TagTranslate::class, ['tag_id' => 'id'])->where(['language' => $language]);
    }

    public function getProductTag($id)
    {
        return ProductTag::find()->where(['tag_id' => $id])->count();
    }


    public function getTagTranslate($tag, $language)
    {
        switch ($language) {
            case 'ru':
                $translation = TagTranslate::find()
                    ->select('name')
                    ->where(['tag_id' => $tag->id, 'language' => 'ru'])
                    ->one();
                $name = $translation ? $translation->name : $tag->name;
                break;

            case 'en':
                $translation = TagTranslate::find()
                    ->select('name')
                    ->where(['tag_id' => $tag->id, 'language' => 'en'])
                    ->one();
                $name = $translation ? $translation->name : $tag->name;
                break;

            default:
                $name = $tag->name;
                break;
        }

        return $name;
    }

    public function getTagSeoTitleTranslate($tag, $language)
    {
        switch ($language) {
            case 'ru':
                $translation = TagTranslate::find()
                    ->select('seo_title')
                    ->where(['tag_id' => $tag->id, 'language' => 'ru'])
                    ->one();
                $seo_title = $translation ? $translation->seo_title : $tag->seo_title;
                break;

            case 'en':
                $translation = TagTranslate::find()
                    ->select('seo_title')
                    ->where(['tag_id' => $tag->id, 'language' => 'en'])
                    ->one();
                $seo_title = $translation ? $translation->seo_title : $tag->seo_title;
                break;

            default:
                $seo_title = $tag->seo_title;
                break;
        }

        return $seo_title;
    }

    public function getTagSeoDescriptionTranslate($tag, $language)
    {
        switch ($language) {
            case 'ru':
                $translation = TagTranslate::find()
                    ->select('seo_description')
                    ->where(['tag_id' => $tag->id, 'language' => 'ru'])
                    ->one();
                $seo_description = $translation ? $translation->seo_description : $tag->seo_description;
                break;

            case 'en':
                $translation = TagTranslate::find()
                    ->select('seo_description')
                    ->where(['tag_id' => $tag->id, 'language' => 'en'])
                    ->one();
                $seo_description = $translation ? $translation->seo_description : $tag->seo_description;
                break;

            default:
                $seo_description = $tag->seo_description;
                break;
        }

        return $seo_description;
    }

    public function getDescriptionTranslate($tag, $language)
    {
        switch ($language) {
            case 'ru':
                $translation = TagTranslate::find()
                    ->select('description')
                    ->where(['tag_id' => $tag->id, 'language' => 'ru'])
                    ->one();
                $description = $translation ? $translation->description : $tag->description;
                break;

            case 'en':
                $translation = TagTranslate::find()
                    ->select('description')
                    ->where(['tag_id' => $tag->id, 'language' => 'en'])
                    ->one();
                $description = $translation ? $translation->description : $tag->description;
                break;

            default:
                $description = $tag->description;
                break;
        }

        return $description;
    }

    public function getCategoriesTag($id)
    {
        $categoryNames = Category::find()
            ->select('name')
            ->distinct()
            ->where(['id' => Product::find()
                ->select('category_id')
                ->distinct()
                ->where(['id' => ProductTag::find()
                    ->select('product_id')
                    ->where(['tag_id' => $id])
                ])
            ])
            ->column();

        return $categoryNames ? implode(', ', $categoryNames) : 'Нет продуктов';
    }

}
