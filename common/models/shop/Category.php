<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $parentId
 * @property string $name
 * @property string $svg
 * @property string $pageTitle
 * @property string $prefix
 * @property string|null $slug
 * @property string|null $file
 * @property string|null $visibility
 * @property string|null $description
 * @property string|null $metaDescription
 * @property string $date_public Дата публикации
 * @property string $date_updated Дата редактирования
 * @property string $keywords
 * @property string $product_keywords
 * @property string $product_footer_description
 * @property string $product_title
 * @property string $product_description
 * @property string $h1
 */
class Category extends ActiveRecord
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
            [['description', 'metaDescription', 'product_footer_description', 'h1'], 'string'],
            [['name', 'pageTitle', 'file', 'visibility', 'svg', 'prefix', 'date_public', 'date_updated', 'keywords', 'product_keywords', 'product_title', 'product_description'], 'string', 'max' => 255],
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
            'svg' => 'SVG',
            'prefix' => 'Prefix',
        ];
    }

    //Возвращает родительскую категорию
    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parentId']);
    }

    public function getParents()
    {
        return $this->hasMany(Category::class, ['parentId' => 'id']);
    }

    public function getTranslations()
    {
        return $this->hasMany(CategoriesTranslate::class, ['category_id' => 'id']);
    }

    public function getTranslation($language)
    {
        return $this->hasOne(CategoriesTranslate::class, ['category_id' => 'id'])->where(['language' => $language]);
    }

    //Возвращает продукты категории
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    //Возвращает свойства категории
    public function getProperties()
    {
        return $this->hasMany(PropertiesName::class, ['id' => 'property_id'])
            ->orderBy(['sort' => SORT_ASC])
            ->viaTable('categories_properties', ['category_id' => 'id']);
    }

    //Для фильтра frontend
    public function getCountProductCategoryFilter($id)
    {
        $subCategories = Category::find()->select('id')->where(['parentId' => $id])->column();
        $allCategories = Category::find()->select('id')->where(['id' => $subCategories])->column();
        $allCategories[] = $id;

        $productCount = Product::find()->where(['category_id' => $allCategories])->count();

        return $productCount;
    }

    public function getCategoryChildFilter($id)
    {
        $categories = Category::find()->select(['id', 'name', 'slug'])
            ->where(['parentId' => $id])
            ->andWhere(['visibility' => 1])
            ->all();
        return $categories;
    }

    public function getBrandsCategoryFilter($id)
    {
        $brandsId = Product::find()->select('brand_id')
            ->where(['category_id' => $id])
            ->asArray()
            ->column();

        $brands = Brand::find()->where(['id' => $brandsId])->all();

        return $brands;
    }

    public function getCounterFilter()
    {
        $brandCheck = Yii::$app->session->get('brandCheckFilter');
        if ($brandCheck == null) {
            $brandCheck = [];
        }
        $propertiesCheck = Yii::$app->session->get('propertiesCheckFilter');
        if ($propertiesCheck == null) {
            $propertiesCheck = [];
        }

        $res = count($brandCheck) + count($propertiesCheck);

        $minPrice = Yii::$app->session->get('minPriceFilter');
        $maxPrice = Yii::$app->session->get('maxPriceFilter');

        return $res;
    }

    public function getPropertiesFilter($categoryId, $propertyId)
    {
        $properties = ProductProperties::find()
            ->select('DISTINCT(value)')
            ->where([
                'property_id' => $propertyId,
                'product_id' => Product::find()
                    ->select('id')
                    ->where(['category_id' => $categoryId])
            ])
            ->column();

        $property = [];
        foreach ($properties as $item) {
            if ($item !== '*') {
                $subArray = preg_split('/,\s+|\s+\+\s+/', $item);
                $property = array_merge($property, array_map('trim', $subArray));
            }
        }

        $property = array_unique($property);
        sort($property);

        return $property;
    }

    public function getPropertiesCountPruductFilter($id, $property)
    {
        return ProductProperties::find()
            ->where(['category_id' => $id])
            ->andWhere(['like', 'value', $property])
            ->count();
    }

    //Для фильтра frontend ---- End

    public function getCountProductCategory($id)
    {
        $cat = [];
        $categories = Category::find()->select('id')->where(['parentId' => $id])->all();
        foreach ($categories as $category) {
            $cat[] = $category->id;
        }
        $products = Product::find()
            ->select('id')
            ->where(['category_id' => $cat])
            ->orWhere(['category_id' => $id])
            ->all();
        $res = [];
        foreach ($products as $product) {
            $res[] = $product;
        }
        if (count($res) > 0) {
            return count($res);

        } else {
            return 0;
        }
    }

    public function getCountProductCategoryChild($id)
    {
        $products = Product::find()->select('id')->where(['category_id' => $id])->all();
        $res = [];
        foreach ($products as $product) {
            $res[] = $product;
        }
        if (count($res) > 0) {
            return count($res);

        } else {
            return 0;
        }
    }

    public function getCatalogHighPrice($id)
    {
        $highPrice = Product::find()
            ->where(['category_id' => $id])
            ->orderBy(['price' => SORT_DESC])
            ->one();

        return $highPrice->price;
    }

    public function getCatalogLowPrice($id)
    {
        $lowPrice = Product::find()
            ->where(['category_id' => $id])
            ->orderBy(['price' => SORT_ASC])
            ->one();

        return $lowPrice->price;
    }

    public function getChildrenHighPrice($res)
    {
        $highPrice = Product::find()
            ->where(['category_id' => $res])
            ->orderBy(['price' => SORT_DESC])
            ->one();

        return $highPrice->price;
    }

    public function getChildrenLowPrice($res)
    {
        $lowPrice = Product::find()
            ->where(['category_id' => $res])
            ->orderBy(['price' => SORT_ASC])
            ->one();

        return $lowPrice->price;
    }

    // Schema.org для микро разметки
    public function getSchemaImg($id)
    {
        if (strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false || strpos($_SERVER['HTTP_USER_AGENT'], ' Chrome/') !== false) {
            $webp_support = true; // webp поддерживается
        } else {
            $webp_support = false; // webp не поддерживается
        }
        $product = Product::find()->with('images')->where(['id' => $id])->one();
        $images = [];
        foreach ($product->images as $image) {
            if ($webp_support == true && isset($image->webp_name)) {
                $images[] = Yii::$app->request->hostInfo . '/product/' . $image->webp_name;
            } else {
                $images[] = Yii::$app->request->hostInfo . '/product/' . $image->name;
            }
        }
        return $images;
    }

    public function getSchemaRatingCategory($id)
    {
        $products = Product::find()
            ->select('id')
            ->where(['category_id' => $id])
            ->asArray()
            ->all();
        $flatArray = array_column($products, 'id');

        $reviews = Review::find()
            ->select('rating')
            ->where(['product_id' => $flatArray])
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

    public function getSchemaCountReviewsCategory($id)
    {
        $products = Product::find()
            ->select('id')
            ->where(['category_id' => $id])
            ->asArray()
            ->all();
        $flatArray = array_column($products, 'id');

        $reviews = Review::find()
            ->select('id')
            ->where(['product_id' => $flatArray])
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

    public function getSchemaRatingChildren($res)
    {
        $products = Product::find()
            ->select('id')
            ->where(['category_id' => $res])
            ->asArray()
            ->all();
        $flatArray = array_column($products, 'id');

        $reviews = Review::find()
            ->select('rating')
            ->where(['product_id' => $flatArray])
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

    public function getSchemaCountReviewsChildren($res)
    {
        $products = Product::find()
            ->select('id')
            ->where(['category_id' => $res])
            ->asArray()
            ->all();
        $flatArray = array_column($products, 'id');

        $reviews = Review::find()
            ->select('id')
            ->where(['product_id' => $flatArray])
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

    // Для site.map
    public function getCategoryStatus($id)
    {
        $category = Category::find()->where(['id' => $id])->one();
        $productCategory = Product::find()->where(['category_id' => $id])->one();

        if ($category->parentId != null or $productCategory != null) {
            return '/product-list/';
        } else {
            return '/catalog/';
        }
    }

    /**
     * Вкладки Tab основная информация
     */
    public function getTabs(): array
    {
        $tabs = [
            [
                'id' => 'description',
                'icon' => 'fas fa-info-circle',
                'label' => 'Основна інформація',
                'active' => true,
                'view' => 'basic-information',
            ],
        ];

//        if (!$this->isNewRecord) {
            $tabs = array_merge($tabs, [
                ['id' => 'seo', 'icon' => 'fas fa-search-dollar', 'label' => 'Просунення в пошуку', 'view' => '@backend/views/_partials/seo-information'],
                ['id' => 'seo-product', 'icon' => 'fas fa-search-dollar', 'label' => 'SEO шаблон', 'view' => 'seo-information-product'],
                ['id' => 'keyword', 'icon' => 'fas fa-key', 'label' => 'Ключові слова', 'view' => 'keywords'],
            ]);
//        }

        return $tabs;
    }
}
