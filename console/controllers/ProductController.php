<?php

namespace console\controllers;

use common\models\shop\Category;
use common\models\shop\Product;
use common\models\shop\ProductProperties;
use common\models\shop\ProductPropertiesTranslate;
use common\models\shop\ProductsTranslate;
use common\models\shop\ProductTag;
use common\models\shop\Tag;
use Stichoza\GoogleTranslate\GoogleTranslate;
use yii\console\Controller;

class ProductController extends Controller
{
    /**
     * Добавление  в footer карточки товара
     */
    public function actionAddFooterDescr()
    {
        $descr = '<p>---------------------------
</p>
<p><strong>Увага!!!</strong>  Для безпечного використання препарату (*name_product*) та досягнення максимальної ефективності його дії, слід строго дотримуватися інструкцій виробника та правил техніки безпеки при обробці хімічних речовин.
</p>
<p>Інтернет-магазин <a href="https://agropro.org.ua/">AgroPro</a> пропонує одні з найвигідніших цін на (*name_product*). Ви можете замовити необхідний препарат на нашому веб-сайті, і наші менеджери оперативно оброблять та доставлять ваше замовлення.
</p>
<p>Наші модератори дуже уважно перевіряють інформацію, перед тим як публікувати її на сайті. Однак, на жаль, дані про товар можуть змінюватися виробником без попередження, тому інтернет-магазин <a href="https://agropro.org.ua/">AgroPro</a> не несе відповідальності за точність опису, і наявна помилка не може служити підставою для повернення товару.
</p>';
        $products = Product::find()->all();
        $categories = [11, 20, 18, 26];
        foreach ($products as $product) {
            if (!in_array($product->category_id, $categories)) {
                $product->footer_description = $descr;
                $product->save();
                echo "\t" . $product->id . " Footer описание добавлено! \t" . $product->category_id . "\n";
            } else {
                echo "\t" . $product->id . " Footer описание НЕ добавлено! \t" . $product->category_id . "\n";
            }
        }
    }

    /**
     * Добавление  в таблицу тип упаковки
     */
    public function actionPackage()
    {
        $products = Product::find()->all();
        $categories = [22, 23, 24, 25];
        foreach ($products as $product) {
            if (!in_array($product->category_id, $categories)) {
                $product->package = 'BIG';
                $product->save();
                echo "\t" . $product->id . " BIG добавлено! \t" . $product->category_id . "\n";
            } else {
                $product->package = 'SMALL';
                $product->save();
                echo "\t" . $product->id . " SMALL добавлено! \t" . $product->category_id . "\n";
            }
        }
    }

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
     * Добавление ID Категории
     */
    public function actionAddCategoryID()
    {
        $i = 1;
        $properties = ProductProperties::find()->all();
        foreach ($properties as $property) {
            $property->category_id = Product::find()->select('category_id')->where(['id' => $property->product_id]);

            if ($property->save(false)) {
                echo "\t" . $i . " Категория добавлена \n";
                $i++;
            }
        }
    }

    /**
     * Добавление Сортировки
     */
    public function actionSortProperties()
    {
        $i = 1;
        $properties = ProductProperties::find()->all();
        foreach ($properties as $property) {

            if ($property->properties == 'діюча речовина:')
                $property->sort = 1;

            if ($property->properties == 'тип:')
                $property->sort = 2;

            if ($property->properties == 'культура:')
                $property->sort = 3;

            if ($property->properties == 'об\'єкт:')
                $property->sort = 4;

            if ($property->properties == 'спосіб дії:')
                $property->sort = 5;

            if ($property->properties == 'препаративна форма:')
                $property->sort = 6;

            if ($property->properties == 'норма витрати:')
                $property->sort = 7;

            if ($property->properties == 'застосування:')
                $property->sort = 8;

            if ($property->properties == 'тара:')
                $property->sort = 9;

            if ($property->properties == 'склад:')
                $property->sort = 1;


            if ($property->save(false)) {
                echo "\t" . $i . " Порядок сортировки изменен \n";
                $i++;
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

    /**
     * Добавление SKU
     */
    public function actionAddSku()
    {
        $i = 1;
        $products = Product::find()->all();
        foreach ($products as $product) {
            $product->sku = 'PRO-100' . $product->id;

            if ($product->save(false)) {
                echo "\t" . $i . " Артикул добавлен \n";
                $i++;
            }
        }
    }

    /**
     * <<<<<<<< ПЕРЕВОД Перевод данных Products
     */
    public function actionTranslateProduct()
    {
        $products = Product::find()
//            ->where(['id' => 2])
            ->all();
        if (!$products) {
            echo "Products not found.\n";
            return;
        }

        foreach ($products as $product) {
            $idProduct = ProductsTranslate::find()->select('product_id')->where(['description' => null])->column();

            $idProduct = array_unique($idProduct);

        }

        $products = Category::find()->where(['id' => $idProduct])->all();
        if (!$products) {
            echo "Products not found.\n";
            return;
        }

        $i = 1;
        foreach ($products as $product) {
            if (strlen($product->description) > 5000) {
                $descrSave = '';

                $sourceLanguage = 'uk'; // Определить язык автоматически
                $targetLanguages = ['ru', 'en']; // Языки перевода

                $tr = new GoogleTranslate();

                foreach ($targetLanguages as $language) {
                    $translation = $product->getTranslation($language)->one();
                    if (!$translation) {
                        $translation = new ProductsTranslate();
                        $translation->product_id = $product->id;
                        $translation->language = $language;
                    }

                    $tr->setSource($sourceLanguage);
                    $tr->setTarget($language);

//                $translation->name = $tr->translate($product->name);

                    if (!empty($product->description)) {
                        if (strlen($product->description) < 5000) {
                            $translation->description = $tr->translate($product->description);
                        } else {
                            $description = $product->description;
                            $translatedDescription = '';
                            $partSize = 5000;
                            $parts = [];

                            // Разбиваем текст на части по 5000 символов, не нарушая структуру тегов
                            while (strlen($description) > $partSize) {
                                $part = substr($description, 0, $partSize);
                                $lastSpace = strrpos($part, ' ');
                                $parts[] = substr($description, 0, $lastSpace);
                                $description = substr($description, $lastSpace);
                            }
                            $parts[] = $description;

                            // Переводим каждую часть отдельно
                            foreach ($parts as $part) {
                                $translatedDescription .= $tr->translate($part);
                            }

                            // Сохраняем переведенное описание
                            $translation->description = $translatedDescription;
                        }
                    } else {
                        // Обработка случая, когда описание пустое
                        $descrSave = 'Descr > 5000 или пустое значение';
                    }

//                $translation->short_description = $tr->translate($product->short_description);
//                $translation->seo_title = $tr->translate($product->seo_title);
//                $translation->seo_description = $tr->translate($product->seo_description);
//                $translation->footer_description = $tr->translate($product->footer_description);

                    if ($translation->save()) {
                        echo "$i  Продукт $product->name переведен и сохранен  $descrSave  для $language.\n";
                    } else {
                        echo "$i  Ошибка во время сохранения $product->name для $language.\n";
                    }
                }
                $i++;
            }
        }
    }

    /**
     * <<<<<<<< ПЕРЕВОД Перевод данных Products Properties
     */
    public function actionTranslateProductProperties()
    {
        $properties = ProductProperties::find()
            ->all();
        if (!$properties) {
            echo "Products not found.\n";
            return;
        }


        $i = 1;
        foreach ($properties as $property) {

            $sourceLanguage = 'uk'; // Определить язык автоматически
            $targetLanguages = ['ru', 'en']; // Языки перевода

            $tr = new GoogleTranslate();

            foreach ($targetLanguages as $language) {
                $translation = $property->getTranslation($language)->one();
                if (!$translation) {
                    $translation = new ProductPropertiesTranslate();
                    $translation->property_id = $property->id;
                    $translation->language = $language;
                }

                $tr->setSource($sourceLanguage);
                $tr->setTarget($language);

                $translation->properties = $tr->translate($property->properties);
                $translation->value = $tr->translate($property->value);

                if ($translation->save()) {
                    echo "$i  Продукт $property->properties переведен и сохранен для $language.\n";
                } else {
                    echo "$i  Ошибка во время сохранения $property->properties для $language.\n";
                }
            }
            $i++;
        }
    }

    /**
     * Найти и перезаписать Характеристики
     */
     
     // Доходный  Pre-emergence
     
    public function actionFindAndReplaceProperty()
    {
        $wordFind = 'Grundovy';
        $wordReplace = 'Soil';

        $properties = ProductPropertiesTranslate::find()
            ->where(['like', 'value', '%' . $wordFind . '%', false]) // false означает, что чувствительность к регистру отключена
            ->all();
        if ($properties) {
            foreach ($properties as $property) {

                $property->value = str_replace($wordFind, $wordReplace, $property->value);
                if ($property->save(true)) {
                    echo $property->id . "\tСлово\t" . $wordFind . "\t заменено на\t" . $wordReplace . "\tрезультат =>\t" . $property->value . "\t" . "\n";
                } else {
                    echo "\tПроизошла ошибка при сохранении!\t" . $property->id . "\t=>\t" . $property->value . "\n";
                }
            }
        } else {
            echo "\tНет результатов для обработки!\t" . $wordFind . "\t=>\t" . $wordReplace . "\n";
        }
    }
}