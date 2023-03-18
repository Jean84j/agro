<?php

namespace common\models\shop;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $parentId
 * @property string $name
 * @property string $pageTitle
 * @property string|null $slug
 * @property string|null $file
 * @property string|null $visibility
 * @property string|null $description
 * @property string|null $metaDescription
 */
class Category extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => 'pageTitle',
                // optional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentId'], 'integer'],
            [['name', 'pageTitle'], 'required'],
            [['description', 'metaDescription'], 'string'],
            [['name', 'pageTitle', 'file', 'visibility'], 'string', 'max' => 255],
            [['name', 'slug'], 'unique'],
            [['slug'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentId' => 'Parent ID',
            'name' => 'Name',
            'pageTitle' => 'Page Title',
            'slug' => 'Slug',
            'file' => 'File',
            'visibility' => 'Visibility',
            'description' => 'Description',
            'metaDescription' => 'Meta Description',
        ];
    }

    public function getParent(){
        return $this->hasOne(Category::class, ['id' => 'parentId']);
    }
    public function getParents(){
        return $this->hasMany(Category::class, ['parentId'=> 'id']);
    }

    public function getProducts(){
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }


}
