<?php

namespace console\controllers;

use common\models\shop\Category;
use common\models\shop\Product;
use common\models\shop\ProductProperties;
use common\models\shop\ProductTag;
use common\models\shop\Tag;
use yii\console\Controller;

class ProductController extends Controller
{

    /**
     * Найти и перезаписать тег <h2>
     */
    public function actionFindAndReplaceTag()
    {
        $products = Product::find()
            ->where(['like', 'description', '%<h2>%', false]) // false означает, что чувствительность к регистру отключена
            ->all();

        if ($products) {
            foreach ($products as $product) {

                $product->description = str_replace('<h2>', '<h4>', $product->description);
                $product->description = str_replace('</h2>', '</h4>', $product->description);

                $product->save(false); // false отключает валидацию, использовать осторожно
                echo "\t" . $product->name . " Teg добавлено! \t" . "\n";
            }
        } else {
            echo "\t" . " Не работает! \t" . "\n";
        }
    }

    /**
     * <<<<<<<< ТЕГИ +++  Добавление Тегов из характеристик товара
     */
    public function actionAddTag()
    {
        $i = 1;
        $tags = Tag::find()->all();
        foreach ($tags as $tag) {
            $products = ProductProperties::find()
                ->where(['LIKE', 'value', $tag->name])
//                ->where(['LIKE', 'value', '%' . $tag['name'] . '%', false])
                ->all();
            foreach ($products as $product) {
                $product_tag = ProductTag::find()->where(['and', ['product_id' => $product->product_id], ['tag_id' => $tag->id]])->one();
                if (!$product_tag) {
                    $tag_new = new ProductTag();
                    $tag_new->product_id = $product->product_id;
                    $tag_new->tag_id = $tag->id;
                    if ($tag_new->save()) {
                        echo $i++ . "\t" . ' Тег ' . $tag->name . ' добавлен товару ' . $product->product_id . "\n";
                    }
                }
            }
        }
    }

    /**
     * Форматирование характеристик
     */
    public function actionFormatProperties()
    {
        $cultura = [];
        $delimiter = ",";
        $properties = ProductProperties::find()->select(['properties', 'value'])->all();
        foreach ($properties as $property) {
            if ($property->properties == 'культура:' && $property->value != null) {
                $cultura[] = explode($delimiter, $property->value);
            }
        }

        // Новый массив
        $newArray = [];

// Обход внешнего массива
        foreach ($cultura as $innerArray) {
            // Обход вложенных массивов
            foreach ($innerArray as $value) {
                // Добавление значения в новый массив
                $newArray[] = $value;
            }
        }
        sort($newArray);
        $newArray = array_unique($newArray);

        echo "\t" . print_r($newArray) . "\n";
    }

    /**
     * Добавление новых характеристик
     */
    public function actionAddNewProperties()
    {
        $sort = 10;
        $catId = 5;

        $nameProperty = 'група:';
        $valueProperty = Category::find()->select('name')->where(['id' => $catId])->one();

        $productsId = ProductProperties::find()
            ->select('product_id')
            ->where(['category_id' => $catId])
            ->distinct()
            ->column();
        $i = 1;
        foreach ($productsId as $item) {
            $nameProduct = Product::find()->select('name')->where(['id' => $item])->one();
            $productProperty = ProductProperties::find()->select('properties')->where(['product_id' => $item])->all();
            $res = 0;
            foreach ($productProperty as $property) {
                if ($property->properties == $nameProperty) {
                    $res = 1;
                }
            }
            if ($res === 0) {
                $model = new ProductProperties();
                $model->product_id = $item;
                $model->properties = $nameProperty;
                $model->value = $valueProperty->name;
                $model->sort = $sort;
                $model->category_id = $catId;
                if ($model->save()) {
                    echo $i . " Новое свойство " . $nameProperty . " сохранено: Для продукта " . $nameProduct->name . "\n";
                    $i++;
                } else {
                    echo "ERROR: Для продукта " . $nameProduct->name . "\n";
                }
            } else {
                echo "### Свойство " . $nameProperty . " уже существует: Для продукта " . $nameProduct->name . "\n";
            }
        }
    }

}