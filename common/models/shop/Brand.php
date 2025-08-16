<?php

namespace common\models\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property int $date_public
 * @property int $date_updated
 * @property string|null $slug
 * @property string|null $name
 * @property string|null $file
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $description
 * @property string|null $keywords
 */
class Brand extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name', 'file', 'keywords', 'seo_description', 'seo_title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['slug', 'name'], 'unique'],
            [['name'], 'required'],
        ];
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
            ],
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'file' => 'File',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(BrandsTranslate::class, ['brand_id' => 'id']);
    }

    public function getTranslation($language)
    {
        return $this->hasOne(BrandsTranslate::class, ['brand_id' => 'id'])->where(['language' => $language]);
    }

    //Для фильтра frontend
    public function getBrandProductCountFilter($brandId, $categoryId)
    {
        return Product::find()
            ->where(['brand_id' => $brandId, 'category_id' => $categoryId])
            ->count();
    }


    public function getProductBrand($id)
    {
        return Product::find()->where(['brand_id' => $id])->count();
    }


    public function getBrandCategories($id)
    {
        $language = Yii::$app->session->get('_language', 'uk');

        $categories_name = Category::find()
            ->alias('c')
            ->select(['IFNULL(ct.name, c.name) AS name'])
            ->leftJoin('categories_translate ct', 'ct.category_id = c.id AND ct.language = :language')
            ->where(['c.id' => Product::find()
                ->select('category_id')
                ->where(['brand_id' => $id])
                ->distinct()
            ])
            ->addParams([':language' => $language])
            ->column();

        return implode(', ', $categories_name);
    }


    public function getColorBrand($i)
    {
        $colors = [
            10 => '#0cdd9d',
            9 => '#bb43df',
            8 => '#198754',
            7 => '#6f42c1',
            6 => '#f907ed',
            5 => '#fd7e14',
            4 => '#e62e2e',
            3 => '#29cccc',
            2 => '#3377ff',
            1 => '#5dc728',
            0 => '#ffd333',
        ];

        return $colors[$i] ?? '#a79ea6';
    }

    public function getProductOrderBrand($id)
    {
        $totalOrderQuantity = OrderItem::find()
            ->joinWith('product')
            ->where(['product.brand_id' => $id])
            ->sum('quantity');

        return $totalOrderQuantity;
    }

    public function getIncomeOrderBrand($id)
    {
        $orderIds = Order::find()->select('id')->where(['order_pay_ment_id' => 3])->column();

        $totalIncome = OrderItem::find()
            ->select(['SUM(order_item.price * order_item.quantity)'])
            ->leftJoin('product', 'order_item.product_id = product.id')
            ->where(['order_item.order_id' => $orderIds])
            ->andWhere(['product.brand_id' => $id])
            ->scalar();

        return $totalIncome;
    }

    public function getCategoriesBrand($id)
    {
        $categoryNames = Category::find()
            ->select('name')
            ->where(['id' => Product::find()->select('category_id')->where(['brand_id' => $id])->distinct()])
            ->column();

        return empty($categoryNames) ? 'Нет продуктов' : implode(', ', array_filter($categoryNames));
    }


}
