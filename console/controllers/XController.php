<?php

namespace console\controllers;

use backend\models\IpBot;
use backend\models\ReportItem;
use common\models\shop\CategoriesProperties;
use common\models\shop\Product;
use common\models\shop\ProductProperties;
use common\models\shop\ProductPropertiesTranslate;
use common\models\shop\ProductTag;
use common\models\shop\PropertiesNameTranslate;
use yii\console\Controller;

class XController extends Controller
{

    /**
     *  Найти похожие IP и заменить их всем диапазоном
     */
    public function actionFindCloneIp()
    {
        $ips = IpBot::find()->select('ip')->column();

        foreach ($ips as $key => $ip) {
            $parts = explode('.', $ip);
            array_pop($parts);
            $ips[$key] = implode('.', $parts) . '.';
        }

        $ips = array_unique($ips);
        $i = 1;

        foreach ($ips as $ip) {
            $ipStatistic = IpBot::find()
                ->where(['like', 'ip', $ip])
                ->count();

            if ($ipStatistic >= 3) {

                $isp = IpBot::find()
                    ->select('isp')
                    ->where(['like', 'ip', $ip])
                    ->scalar();

                if ($isp) {
                    $model = new IpBot();
                    $model->ip = $ip;
                    $model->isp = $isp;
                    $model->blocking = 1;
                    $model->comment = 'Весь диапазон IP';

                    if ($model->save()) {
                        IpBot::deleteAll([
                            'and',
                            ['like', 'ip', $ip],
                            ['!=', 'id', $model->id],
                        ]);
                        echo "$i \t  У \t $ip \t совпадений \t $ipStatistic \n";
                        $i++;
                    } else {
                        dd($model->errors);
                    }
                } else {
                    echo "ISP не существует \n";
                }
            }
        }
    }

    /**
     *  Добавление Тегов продуктам по категориям
     */
    public function actionTagProducts()
    {
        $categoryId = 5;
        $tagId = 86;

        $productsId = Product::find()
            ->select('id')
            ->where(['category_id' => $categoryId])
            ->andWhere(['not in', 'id', ProductTag::find()->select('product_id')->where(['tag_id' => $tagId])])
            ->column();
        if ($productsId) {
            $i = 1;
            foreach ($productsId as $item) {
                $model = new ProductTag();
                $model->product_id = $item;
                $model->tag_id = $tagId;
                if ($model->save()) {
                    echo "$i \t  Сохранено  \n";
                } else {
                    dd($model->errors);
                }
                $i++;
            }
        } else {
            echo "\n\t  Нет результатов для \tКатегории $categoryId \tи \tТега $tagId \n";
        }
    }


    //======================================================

    /**
     *  Исправление свойств ID в переводах продуктов
     */
    public function actionAuditProductProperties()
    {
        $languages = ['ru', 'en'];

        // Загружаем все ProductProperties
        $productsP = ProductProperties::find()
            ->select([
                'id AS pp_id',
                'product_id',
                'property_id AS property_id_uk',
            ])
            ->asArray()
            ->all();

        // Массив для кеширования переведённых свойств
        $propertyTranslations = [];

        // Заполняем переводы для всех продуктов одним запросом
        foreach ($languages as $lang) {
            $propertyTranslations[$lang] = PropertiesNameTranslate::find()
                ->select(['id', 'name_id'])
                ->where(['language' => $lang])
                ->indexBy('name_id') // Индексируем по name_id для быстрого поиска
                ->asArray()
                ->column();
        }

        // Добавляем переводы в productsP
        foreach ($productsP as $index => $productP) {
            foreach ($languages as $lang) {
                $key = 'property_id_' . $lang;
                $productsP[$index][$key] = $propertyTranslations[$lang][$productP['property_id_uk']] ?? null;
            }
        }

        $i = 1;

        // Загружаем все ProductPropertiesTranslate одним запросом
        $productsPT = ProductPropertiesTranslate::find()
            ->select(['id', 'propertyName_id', 'product_id', 'product_properties_id', 'language'])
            ->where(['language' => $languages])
            ->asArray()
            ->all();

        // Индексируем по product_id для быстрого доступа
        $productsPTGrouped = [];
        foreach ($productsPT as $productPT) {
            $productsPTGrouped[$productPT['product_id']][] = $productPT;
        }

        foreach ($productsP as $productP) {
            if (!isset($productsPTGrouped[$productP['product_id']])) {
                echo "$i\tНе существует\n";
                $i++;
                continue;
            }

            foreach ($productsPTGrouped[$productP['product_id']] as $productPT) {
                $lang = $productPT['language'];
                $key = 'property_id_' . $lang;

                if ($productP['pp_id'] !== $productPT['product_properties_id'] && $productP[$key] == $productPT['propertyName_id']) {
                    $model = ProductPropertiesTranslate::findOne(['id' => $productPT['id'], 'language' => $lang]);

                    if ($model) {
                        $model->product_properties_id = $productP['pp_id'];
//                         $model->save(); // Раскомментировать для сохранения

                        echo "$i\t{$productP['product_id']}\t{$productP['pp_id']} \t + \t Перезаписано! \t PP_{$lang} {$productP[$key]}\t PPT_{$lang} {$productPT['propertyName_id']}\t ID {$productPT['product_properties_id']}\n";
                    }
                } else {
                    echo "$i\t{$productP['product_id']}\t{$productP['pp_id']} \t - \t Не Записано! \t PP_{$lang} {$productP[$key]}\t PPT_{$lang} {$productPT['propertyName_id']}\t ID {$productPT['product_properties_id']}\n";
                }

                $i++;
            }
        }
    }

    /**
     *  Имена продуктов в Report
     */
    public function actionReportProductsName()
    {

        $productsName = Product::find()
            ->select(['name'])
            ->asArray()
            ->column();

        $products = ReportItem::find()
            ->select(['product_name', 'COUNT(*) AS count'])
            ->groupBy('product_name')
            ->orderBy(['product_name' => SORT_ASC])
            ->asArray()
            ->all();

        usort($products, function ($a, $b) {
            return strcmp($a['product_name'], $b['product_name']);
        });

        $i = 1;
        foreach ($products as $product) {

            echo "\t $i \t" . $product['count'] . "\t " . $product['product_name'] . "\n";
            $i++;

        }

    }

    /**
     *  Удалить строку из Footer Description
     */
    public function actionFooterDescriptionSub()
    {
//        $string = '<p>---------------------------</p>';
        $string = '<p>--------------------------- </p>';

        $products = Product::find()
            ->select(['id', 'footer_description'])
            ->all();

        foreach ($products as $product) {

                if (str_contains($product->footer_description, $string)) {

                    // Удаляем строку
                    $product->footer_description = str_replace($string, '', $product->footer_description);

                    // Сохраняем без валидации
                    $product->save(false);

                    echo " Обновлён товар ID: {$product->id}\n";
                }

        }
    }

    //======================================================

    /**
     *  Добввить товарам недостающие свойства из категории
     */
    public function actionAddPropertiesProducts()
    {

        $categoryId = 18;

        $categoryPropertiesId = CategoriesProperties::find()
            ->select('property_id')
            ->where(['category_id' => $categoryId])
            ->column();

        $productsId = Product::find()
            ->select('id')
            ->where(['category_id' => $categoryId])
            ->column();

        foreach ($productsId as $productId) {
            foreach ($categoryPropertiesId as $propertyId) {
                $productProperties = ProductProperties::find()
                    ->where(['product_id' => $productId])
                    ->andWhere(['property_id' => $propertyId])
                    ->asArray()
                    ->all();

                if (!$productProperties) {

                    $property = new ProductProperties();
                    $property->product_id = $productId;
                    $property->property_id = $propertyId;
                    $property->category_id = $categoryId;

                    if ($property->save()) {

                        echo "\t Сохранено свойство \n";

                        $propertyIdTranslate = PropertiesNameTranslate::find()
                            ->select('id')
                            ->where(['name_id' => $propertyId])
                            ->andWhere(['language' => 'ru'])
                            ->one();

                        $propertyTranslate = new ProductPropertiesTranslate();
                        $propertyTranslate->product_properties_id = $property->id;
                        $propertyTranslate->language = 'ru';
                        $propertyTranslate->propertyName_id = $propertyIdTranslate->id;
                        $propertyTranslate->product_id = $productId;

                        if ($propertyTranslate->save()) {

                            echo "\t Сохранено свойство перевод \n";

                        } else {
                            dd($propertyTranslate->errors);
                        }
                    } else {
                        dd($property->errors);
                    }
                }
            }
        }
    }

}