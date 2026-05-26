<?php

namespace backend\models;

use common\models\shop\Product;
use common\models\shop\ProductProperties;
use common\models\shop\ProductsTranslate;
use common\models\shop\ProductTag;
use common\models\shop\Tag;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "search_words".
 *
 * @property int $id
 * @property string|null $word
 * @property int|null $counts_query
 */
class SearchWords extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'search_words';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['word', 'counts_query'], 'default', 'value' => null],
            [['counts_query'], 'integer'],
            [['word'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => 'Word',
            'counts_query' => 'Counts Query',
        ];
    }

    public function getCountSearchResult($q): int
    {
        $id_prod = [];

        // Поиск по тегам
        $id_tag = Tag::find()->select('id')->where(['like', 'name', $q])->column();
        if ($id_tag) {
            $tag_products = ProductTag::find()->select('product_id')->where(['in', 'tag_id', $id_tag])->column();
            $id_prod = array_merge($id_prod, $tag_products);
        }

        // Поиск по свойствам
        $val_products = ProductProperties::find()->select('product_id')->where(['like', 'value', $q])->column();
        $id_prod = array_merge($id_prod, $val_products);

        // Поиск по продуктам
        $product_ids = Product::find()
            ->select('id')
            ->where(['like', 'sku', $q])
            ->orWhere(['like', 'keywords', $q])
            ->orWhere(['like', 'name', $q])
            ->column();

        $product_ids_ru = ProductsTranslate::find()
            ->select('product_id')
            ->where(['like', 'keywords', $q])
            ->orWhere(['like', 'name', $q])
            ->column();

        $id_prod = array_merge($id_prod, $product_ids, $product_ids_ru);

        $id_prod = array_unique($id_prod);

        return count($id_prod);

    }

}
