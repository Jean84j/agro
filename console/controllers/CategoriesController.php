<?php

namespace console\controllers;

use common\models\shop\AuxiliaryCategories;
use common\models\shop\AuxiliaryTranslate;
use common\models\shop\CategoriesTranslate;
use common\models\shop\Category;
use Stichoza\GoogleTranslate\GoogleTranslate;
use yii\console\Controller;

class CategoriesController extends Controller
{

    /**
     * <<<<<<<< ПЕРЕВОД Перевод данных Categories
     */
    public function actionTranslateCategory()
    {
        $categories = Category::find()->all();
        if (!$categories) {
            echo "Category not found.\n";
            return;
        }

//        foreach ($categories as $category) {
//            $idCategory = CategoriesTranslate::find()->select('category_id')->where(['description' => null])->column();
//
//            $idCategory = array_unique($idCategory);
//
//        }
//
//        $categories = Category::find()->where(['id' => $idCategory])->all();
//        if (!$categories) {
//            echo "Category not found.\n";
//            return;
//        }

        $i = 1;
        foreach ($categories as $category) {

            $descrSave = '';

            $sourceLanguage = 'uk'; // Исходный язык
            $targetLanguages = ['ru', 'en']; // Языки перевода

            $tr = new GoogleTranslate();

            foreach ($targetLanguages as $language) {
                $translation = $category->getTranslation($language)->one();
                if (!$translation) {
                    $translation = new CategoriesTranslate();
                    $translation->category_id = $category->id;
                    $translation->language = $language;
                }

                $tr->setSource($sourceLanguage);
                $tr->setTarget($language);

//                $translation->name = $tr->translate($category->name ?? '');

                if (!empty($category->description)) {
                    if (strlen($category->description) < 5000) {
                        $translation->description = $tr->translate($category->description);
                    } else {
                        $description = $category->description;
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


//                $translation->pageTitle = $tr->translate($category->pageTitle ?? '');
//                $translation->metaDescription = $tr->translate($category->metaDescription ?? '');
//                $translation->prefix = $tr->translate($category->prefix ?? '');

                if ($translation->save()) {
                    echo "$i  Категория $category->name переведена и сохранена $descrSave для $language.\n";
                } else {
                    echo "$i  Ошибка во время сохранения $category->name для $language.\n";
                }
            }
            $i++;
        }
    }

    /**
     * <<<<<<<< ПЕРЕВОД Перевод данных Auxiliary Categories
     */
    public function actionTranslateAuxiliaryCategory()
    {
        $categories = AuxiliaryCategories::find()->all();
        if (!$categories) {
            echo "Category not found.\n";
            return;
        }

        $i = 1;
        foreach ($categories as $category) {

            $descrSave = '';

            $sourceLanguage = 'uk'; // Исходный язык
            $targetLanguages = ['ru', 'en']; // Языки перевода

            $tr = new GoogleTranslate();

            foreach ($targetLanguages as $language) {
                $translation = $category->getTranslation($language)->one();

                if (!$translation) {
                    $translation = new AuxiliaryTranslate();
                    $translation->category_id = $category->id;
                    $translation->language = $language;
                }

                $tr->setSource($sourceLanguage);
                $tr->setTarget($language);

                $translation->name = $tr->translate($category->name ?? '');
                $translation->pageTitle = $tr->translate($category->pageTitle ?? '');
                $translation->metaDescription = $tr->translate($category->metaDescription ?? '');

                if (!empty($category->description)) {
                    if (strlen($category->description) < 5000) {
                        $translation->description = $tr->translate($category->description);
                    } else {
                        $description = $category->description;
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

                if ($translation->save()) {
                    echo "$i  Категория $category->name переведена и сохранена $descrSave для $language.\n";
                } else {
                    $errors = $translation->getErrors();
                    echo "$i  Ошибка во время сохранения $category->name для $language: " . print_r($errors, true) . "\n";
                }

            }
            $i++;
        }
    }
}
