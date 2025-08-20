<?php

namespace common\models\shop;

use common\models\Settings;
use Spatie\SchemaOrg\Schema;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property string $slug
 * @property string $brand_id
 * @property string $description
 * @property string $footer_description
 * @property string $short_description
 * @property string $currency
 * @property string $package
 * @property float $price
 * @property float|null $old_price
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property int $status_id
 * @property int $category_id
 * @property int $label_id
 * @property string $date_public Дата публикации
 * @property string|null $date_updated Дата редактирования
 * @property string|null $keywords
 * @property string|null $h1
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
                'attribute' => 'slug',
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
    public function rules()
    {
        return [
            [['name', 'description', 'short_description', 'price', 'status_id', 'package', 'category_id', 'slug'], 'required'],
            [['description', 'footer_description', 'short_description', 'currency', 'keywords'], 'string'],
            [['price', 'old_price'], 'number'],
            [['status_id', 'category_id', 'label_id', 'brand_id'], 'safe'],
            [['name', 'h1', 'seo_title', 'seo_description', 'package', 'slug', 'sku'], 'string', 'max' => 255],
            [['name', 'slug'], 'unique'],
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
            'brand_id' => Yii::t('app', 'Brand'),
            'slug' => Yii::t('app', 'Slug'),
            'currency' => Yii::t('app', 'Currency'),
            'description' => Yii::t('app', 'Description'),
            'short_description' => Yii::t('app', 'Short Description'),
            'price' => Yii::t('app', 'Price'),
            'old_price' => Yii::t('app', 'Old Price'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'status_id' => Yii::t('app', 'Status'),
            'category_id' => Yii::t('app', 'Category'),
            'label_id' => Yii::t('app', 'Label'),
            'sku' => Yii::t('app', 'SKU'),
            'footer_description' => Yii::t('app', 'Footer Description'),
            'package' => Yii::t('app', 'Package'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[ProductsTranslate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ProductsTranslate::class, ['product_id' => 'id']);
    }

    public function getTranslation($language)
    {
        return $this->hasOne(ProductsTranslate::class, ['product_id' => 'id'])->where(['language' => $language]);
    }

    /**
     * Gets query for [[ProductGrups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductGrups()
    {
        return $this->hasMany(ProductGrup::class, ['product_id' => 'id']);
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

    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'id']);
    }

    public function getProductTags()
    {
        return $this->hasMany(ProductTag::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Grups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrups()
    {
        return $this->hasMany(Grup::class, ['id' => 'grup_id'])
            ->viaTable('product_grup', ['product_id' => 'id']);
    }

    public function getGrup()
    {
        return $this->hasOne(Grup::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[AnalogProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalogs()
    {
        return $this->hasMany(Product::class, ['id' => 'analog_product_id'])
            ->viaTable('analog_products', ['product_id' => 'id']);
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
        return $this->hasMany(ProductImage::class, ['product_id' => 'id'])->orderBy(['priority' => SORT_ASC]);
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    public function getProperties()
    {
        return $this->hasMany(ProductProperties::class, ['product_id' => 'id'])
            ->orderBy(['sort' => SORT_ASC]);
    }

    public function getReviews()
    {
        return $this->hasMany(Review::class, ['product_id' => 'id'])->orderBy(['created_at' => SORT_ASC]);
    }

    public function getPrice()
    {
        if ($this->currency === 'UAH') {
            return $this->price;
        } else {
            return floatval($this->price) * floatval(Settings::currencyRate($this->currency));
        }
    }

    public function getOldPrice()
    {
        if ($this->currency === 'UAH') {
            return $this->old_price;
        } else {
            return floatval($this->old_price) * floatval(Settings::currencyRate($this->currency));
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIssetToCart($product_id)
    {
        $isset_to_cart = null;
        if (isset($_SESSION['agro_cart'])) {
            $keys = array_keys(unserialize($_SESSION['agro_cart']));

            if (in_array($product_id, $keys)) {
                $isset_to_cart = Yii::$app->cart->getPositions()[$product_id];
            }
        }
        return $isset_to_cart;
    }

    public function getSchemaImg($id)
    {
        $product = Product::find()->with('images')->where(['id' => $id])->one();

        $images = $product->images;
        if (isset($images[0])) {
            $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->name;
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }

    public function getSchemaRating($id)
    {
        $reviews = Review::find()->where(['product_id' => $id])->all();
        $res = [];
        foreach ($reviews as $review) {
            $res[] = $review->rating;
        }
        if (count($res) > 0) {
            return array_sum($res) / count($res);

        } else {
            return '4.4';
        }
    }

    public function getSchemaCountReviews($id)
    {
        $reviews = Review::find()->where(['product_id' => $id])->all();
        $res = [];
        foreach ($reviews as $review) {
            $res[] = $review;
        }
        if (count($res) > 0) {
            return count($res);

        } else {
            return '3';
        }
    }

    public function getImgOne($id)
    {
        $webp_support = ProductImage::imageWebp();
        $product = Product::find()->with('images')->where(['id' => $id])->one();
        $images = $product->images;
        if (isset($images[0])) {
            if ($webp_support == true && isset($images[0]->webp_name)) {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->webp_name;
            } else {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->name;
            }
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }

    public function getImgSeo($id)
    {
        $webp_support = ProductImage::imageWebp();

        $product = Product::find()->with('images')->where(['id' => $id])->one();

        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);

        if (isset($images[0])) {
            if ($webp_support == true && isset($images[0]->webp_large)) {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->webp_large;
            } else {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->large;
            }
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }

    // 350 * 350
    public function getImgOneExtraExtraLarge($id)
    {
        $webp_support = ProductImage::imageWebp();
        $product = Product::find()->with('images')->where(['id' => $id])->one();

        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);

        if (isset($images[0])) {
            if ($webp_support == true && isset($images[0]->webp_extra_extra_large)) {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->webp_extra_extra_large;
            } else {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->extra_extra_large;
            }
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }

    // 290 * 290
    public function getImgOneExtraLarge($id)
    {
        $webp_support = ProductImage::imageWebp();
        $product = Product::find()->with('images')->where(['id' => $id])->one();

        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);

        if (isset($images[0])) {
            if ($webp_support == true && isset($images[0]->webp_extra_large)) {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->webp_extra_large;
            } else {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->extra_large;
            }
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }

    //  195 * 195
    public function getImgOneLarge($id)
    {
        $webp_support = ProductImage::imageWebp();
        $product = Product::find()->with('images')->where(['id' => $id])->one();

        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);

        if (isset($images[0])) {
            if ($webp_support == true && isset($images[0]->webp_large)) {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->webp_large;
            } else {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->large;
            }
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }

    // 150 * 150
    public function getImgOneMedium($id)
    {
        $webp_support = ProductImage::imageWebp();
        $product = Product::find()->with('images')->where(['id' => $id])->one();

        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);

        if (isset($images[0])) {
            if ($webp_support == true && isset($images[0]->webp_medium)) {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->webp_medium;
            } else {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->medium;
            }
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }

    // 90 * 90
    public
    function getImgOneSmall($id)
    {
        $webp_support = ProductImage::imageWebp();
        $product = Product::find()->with('images')->where(['id' => $id])->one();

        $images = $product->images;
        $priorities = array_column($images, 'priority');
        array_multisort($priorities, SORT_ASC, $images);

        if (isset($images[0])) {
            if ($webp_support == true && isset($images[0]->webp_small)) {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->webp_small;
            } else {
                $img = Yii::$app->request->hostInfo . '/product/' . $images[0]->small;
            }
        } else {
            $img = Yii::$app->request->hostInfo . "/images/no-image.png";
        }
        return $img;
    }

    // 64 * 64
    public
    function getImgOneExtraSmal($id)
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

    public static function productParamsList($id)
    {
        $language = Yii::$app->language;

        $product_params = ProductProperties::find()
            ->alias('pp')
            ->select([
                'COALESCE(pnt.name, pn.name) AS properties',
                'COALESCE(ppt.value, pp.value) AS value',
            ])
            ->leftJoin(
                'properties_name pn',
                'pn.id = pp.property_id'
            )
            ->leftJoin(
                'properties_name_translate pnt',
                'pnt.name_id = pn.id AND pnt.language = :language'
            )
            ->leftJoin(
                'product_properties_translate ppt',
                'ppt.product_properties_id = pp.id AND ppt.language = :language'
            )
            ->where(['pp.product_id' => $id])
            ->asArray()
            ->orderBy(['pn.sort' => SORT_ASC])
            ->addParams([':language' => $language])
            ->all();

        $title_param = array_reduce($product_params, function ($html, $params) {
            if (!empty($params['value']) && $params['value'] !== '*') {
                $html .= '<li class="param-item">'
                    . htmlspecialchars($params['properties']) . ': '
                    . '<b>' . htmlspecialchars($params['value']) . '</b></li>';
            }
            return $html;
        }, '');

        if (empty($title_param)) {
            $title_param = '-------------------------<br>
                    параметри заповнюються<br>
                    -------------------------<br>';
        }


        return $title_param;
    }

    public
    function getRatingCount($id)
    {
        $product = Product::find()->with('reviews')->where(['id' => $id])->one();
        $res = '<a href="#tab-reviews"> 0 (Не оцінювалось)</a>';
        if ($product->reviews) {
            $s = [];
            foreach ($product->reviews as $review) {
                $s[] = $review->rating;
            }
            $res = array_sum($s) / count($product->reviews);
            $count = count($product->reviews);
            $res = '<a href="#tab-reviews"> ' . Yii::$app->formatter->asDecimal($res, 1) . ' (' . $count . ' оцінок)</a>';
        }
        return $res;
    }

    public
    function getRating($id, $w = 18, $h = 17)
    {
        $product = Product::find()->with('reviews')->where(['id' => $id])->one();

        $res = '
            <div class="rating">
                                                    <div class="rating__body">';
        if ($product->reviews) {
            $s = [];
            foreach ($product->reviews as $review) {
                $s[] = $review->rating;
            }
            $rating = round(array_sum($s) / count($product->reviews));

            if ($rating != null) {
                for ($i = 1; $i <= $rating; $i++) {
                    $res .= '<svg class="rating__star rating__star--active" width="' . $w . 'px" height="' . $h . 'px">
                                                                    <g class="rating__fill">
                                                                        <use xlink:href="/images/sprite.svg#star-normal"></use>
                                                                    </g>
                                                                    <g class="rating__stroke">
                                                                        <use xlink:href="/images/sprite.svg#star-normal-stroke"></use>
                                                                    </g>
                                                                </svg>
                                                                <div class="rating__star rating__star--only-edge rating__star--active">
                                                                <div class="rating__fill">
                                                                    <div class="fake-svg-icon"></div>
                                                                </div>
                                                                <div class="rating__stroke">
                                                                    <div class="fake-svg-icon"></div>
                                                                </div>
                                                            </div>';
                }
                if (5 - $rating != 0) {
                    for ($i = 1; $i <= 5 - $rating; $i++) {
                        $res .= '<svg class="rating__star " width="' . $w . 'px" height="' . $h . 'px">
                                                                        <g class="rating__fill">
                                                                            <use xlink:href="/images/sprite.svg#star-normal"></use>
                                                                        </g>
                                                                        <g class="rating__stroke">
                                                                            <use xlink:href="/images/sprite.svg#star-normal-stroke"></use>
                                                                        </g>
                                                                    </svg>
                                                                    <div class="rating__star rating__star--only-edge ">
                                                                        <div class="rating__fill">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                        <div class="rating__stroke">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                    </div>';
                    }
                }
            }

        } else {
            for ($i = 1; $i <= 5; $i++) {
                $res .= '<svg class="rating__star " width="' . $w . 'px" height="' . $h . 'px">
                                                                    <g class="rating__fill">
                                                                        <use xlink:href="/images/sprite.svg#star-normal"></use>
                                                                    </g>
                                                                    <g class="rating__stroke">
                                                                        <use xlink:href="/images/sprite.svg#star-normal-stroke"></use>
                                                                    </g>
                                                                </svg>
                                                                <div class="rating__star rating__star--only-edge ">
                                                                <div class="rating__fill">
                                                                    <div class="fake-svg-icon"></div>
                                                                </div>
                                                                <div class="rating__stroke">
                                                                    <div class="fake-svg-icon"></div>
                                                                </div>
                                                            </div>';
            }
        }
        $res .= '</div>
                                                </div>';

        return $res;
    }

    public function getFooterDescription($description, $name)
    {
        if ($description) {
            $footer_descr = str_replace("(*name_product*)", '<b>' . $name . '</b>', $description);
            return $footer_descr;
        } else {
            return '';
        }
    }

    public function getAvailabilityProduct($status_id)
    {
        if ($status_id === 2) {
            $status = 'http://schema.org/OutOfStock';
        } elseif ($status_id === 1) {
            $status = 'https://schema.org/InStock';
        } else {
            $status = 'https://schema.org/PreOrder';
        }
        return $status;
    }

    public function getCompareProperty($id, $property)
    {
        if (empty($id) || empty($property)) {
            return '---';
        }

        $language = Yii::$app->language;

        $value = ProductProperties::find()
            ->alias('p')
            ->select(['COALESCE(pt.value, p.value) AS value'])
            ->leftJoin('product_properties_translate pt', 'pt.propertyName_id = p.id AND pt.language = :language')
            ->where(['p.product_id' => $id, 'p.property_id' => $property])
            ->addParams([':language' => $language])
            ->limit(1)
            ->scalar();

        return ($value !== false && $value !== '*') ? $value : '---';
    }

    public function getSchemaBreadcrumb()
    {
        return Schema::breadcrumbList()
            ->itemListElement([
                Schema::listItem()
                    ->position(1)
                    ->item(Schema::webPage()
                        ->name(Yii::t('app', 'Головна'))
                        ->url(Url::to('/', true))
                        ->setProperty('id', Url::to('/', true))
                        ->setProperty('inLanguage', Yii::$app->language)),
                Schema::listItem()
                    ->position(2)
                    ->item(Schema::webPage()
                        ->name($this->category->name)
                        ->url(Url::to(['category/catalog', 'slug' => $this->category->slug], true))
                        ->setProperty('id', Url::to(['category/catalog', 'slug' => $this->category->slug], true))
                        ->setProperty('inLanguage', Yii::$app->language)),
                Schema::listItem()
                    ->position(3)
                    ->item(Schema::webPage()
                        ->name($this->name)
                        ->url(Url::to(['product/view', 'slug' => $this->slug], true))
                        ->setProperty('id', Url::to(['product/view', 'slug' => $this->slug], true))),
            ]);
    }

    public function getSchemaProduct()
    {
        $reviews = [];
        $itemCondition[] = 'NewCondition';
        $returnFees[] = 'FreeReturn';
        $returnPolicyCategory[] = 'MerchantReturnFiniteReturnWindow';
        $returnMethod[] = 'ReturnByMail';
        $availabilityProduct[] = $this->getAvailabilityProduct($this->status_id);
        $merchantReturnDescription = 'У нашому онлайн-магазині ми надаємо вам можливість повернути будь-який придбаний товар. 
                    Відповідно до "Закону про захист прав споживачів", 
                    протягом перших 14 днів після покупки у нас ви можете здійснити обмін або повернення товару. 
                    Важливо зазначити, що ми приймаємо на обмін або повернення лише новий товар, 
                    який не має слідів використання і зберігає оригінальну комплектацію та упаковку.';
        $priceValidUntil[] = date('Y-m-d', strtotime("+1 month"));
        $product_reviews = Review::find()->where(['product_id' => $this->id])->all();
        if ($product_reviews) {
            foreach ($product_reviews as $product_review) {
                $formatter = new Formatter();
                $schemaDate = [];
                $schemaDate[] = $formatter->asDatetime($product_review->created_at, 'php:Y-m-d\TH:i:sP');

                $reviews[] = Schema::review()
                    ->datePublished($schemaDate)
                    ->reviewBody($product_review->message)
                    ->author(Schema::person()
                        ->name($product_review->name))
                    ->reviewRating(Schema::rating()
                        ->ratingValue($product_review->rating)
                        ->bestRating(5)
                        ->worstRating(1));
            }
        } else {
            $reviews[] = Schema::review()
                ->author(Schema::person()
                    ->name('Tatyana Khalimon')
                    ->datePublished('2024-06-07')
                    ->reviewBody('Все ОК. Гарний товар.')
                    ->reviewRating(Schema::rating()
                        ->ratingValue(4)
                        ->bestRating(5)
                        ->worstRating(1)));
        }
        return Schema::product()
            ->name($this->name)
            ->url(Yii::$app->request->absoluteUrl)
            ->image($this->getSchemaImg($this->id))
            ->description(strip_tags($this->short_description))
            ->sku($this->sku)
            ->mpn($this->id . '-' . $this->id)
            ->brand(Schema::brand()->name($this->brand ? $this->brand->name : 'AgroPro'))
            ->review($reviews)
            ->aggregateRating(Schema::aggregateRating()
                ->ratingValue($this->getSchemaRating($this->id))
                ->reviewCount($this->getSchemaCountReviews($this->id)))
            ->offers(Schema::offer()
                ->url(Yii::$app->request->absoluteUrl)
                ->image($this->getSchemaImg($this->id))
                ->priceCurrency("UAH")
                ->price($this->getPrice())
                ->priceValidUntil($priceValidUntil)
                ->itemCondition($itemCondition)
                ->availability($availabilityProduct)
                ->hasMerchantReturnPolicy(Schema::merchantReturnPolicy()
                    ->name(Yii::t('app', 'Умови повернення'))
                    ->description($merchantReturnDescription)
                    ->returnMethod($returnMethod)
                    ->merchantReturnDays(14)
                    ->returnFees($returnFees)
                    ->returnPolicyCategory($returnPolicyCategory)
                    ->applicableCountry('UA')
                )
                ->shippingDetails(Schema::offerShippingDetails()
                    ->shippingLabel(Yii::t('app', 'Доставка по тарифу перевізника'))
                    ->deliveryTime(Schema::shippingDeliveryTime()
                        ->transitTime(Schema::quantitativeValue()
                            ->unitCode('d')
                            ->minValue(1)
                            ->maxValue(10))
                        ->handlingTime(Schema::quantitativeValue()
                            ->unitCode('d')
                            ->minValue(1)
                            ->maxValue(2)
                        )
                    )
                    ->shippingDestination(Schema::definedRegion()
                        ->addressCountry('UA')
                        ->addressRegion(Yii::t('app', 'Полтава'))
                    )
                    ->shippingRate(Schema::monetaryAmount()
                        ->currency("UAH")
                        ->value(40)
                    )
                )
            );
    }

}