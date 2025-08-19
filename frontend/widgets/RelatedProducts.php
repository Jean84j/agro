<?php


namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;
use common\models\shop\Product;
use Yii;
use yii\db\Expression;

class RelatedProducts extends BaseWidgetFronted
{

    public function init()
    {
        parent::init();

    }
    public $package;

    public function run()
    {
        $language = Yii::$app->language;

        $title = 'Може зацікавити';

        $package = $this->package;
        $products = Product::find()
            ->select([
                'id',
                'name',
                'slug',
                'price',
                'old_price',
                'status_id',
                'label_id',
                'currency',
                'package',
                'category_id',
            ])
            ->where(['IN', 'status_id', [1, 3, 4]])
            ->andWhere(['package' => $package])
            ->orderBy(new Expression('RAND()'))
            ->limit(15)
            ->all();

        $products = $this->translateProductsItem($language, $products);

        return $this->render('products-carousel-slide',
            [
                'products' => $products,
                'language' => $language,
                'title' => $title,
            ]);
    }


}
