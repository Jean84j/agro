<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $short_description
 * @property float $price
 * @property float|null $old_price
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property int $status_id
 * @property int $category_id
 * @property int $label_id
 *
 * @property ProductTag[] $productTags
 * @property Tag[] $tags
 */
class Product extends ActiveRecord implements CartPositionInterface
{

    use CartPositionTrait;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
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
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'short_description', 'price', 'status_id', 'category_id'], 'required'],
            [['description', 'short_description'], 'string'],
            [['price', 'old_price'], 'number'],
            [['status_id', 'category_id', 'label_id'], 'safe'],
            [['name', 'seo_title', 'seo_description', 'slug'], 'string', 'max' => 255],
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
            'short_description' => Yii::t('app', 'Short Description'),
            'price' => Yii::t('app', 'Price'),
            'old_price' => Yii::t('app', 'Old Price'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'status_id' => Yii::t('app', 'Status'),
            'category_id' => Yii::t('app', 'Category'),
            'label_id' => Yii::t('app', 'Label'),
        ];
    }

    /**
     * Gets query for [[ProductTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTags()
    {
        return $this->hasMany(ProductTag::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('product_tag', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }
    /**
     * Gets query for [[Label]].
     *
     * @return \yii\db\ActiveQuery
     *
     */
    public function getLabel()
    {
        return $this->hasOne(Label::class, ['id' => 'label_id']);
    }

    /**
     * Gets query for [[ProductImage]].
     *
     * @return \yii\db\ActiveQuery
     *
     */
    public function getImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id']);
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIssetToCart($product_id){
        $isset_to_cart = null;
        if(isset($_SESSION['agro_cart'])){
            $keys = array_keys(unserialize($_SESSION['agro_cart']));

            if(in_array($product_id, $keys)){
                $isset_to_cart = Yii::$app->cart->getPositions()[$product_id];
            }
        }
        return $isset_to_cart;
    }
}
