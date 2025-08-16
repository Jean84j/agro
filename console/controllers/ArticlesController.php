<?php

namespace console\controllers;

use common\models\Posts;
use common\models\PostsTranslate;
use Stichoza\GoogleTranslate\GoogleTranslate;
use yii\console\Controller;

class ArticlesController extends Controller
{
    /**
     * <<<<<<<< ПЕРЕВОД Перевод данных Posts
     */
    public function actionArticlesTranslate()
    {
        $posts = Posts::find()->where(['id' => 6])->all();
        if (!$posts) {
            echo "Posts not found.\n";
            return;
        }

        $i = 1;
        foreach ($posts as $post) {

            $descrSave = '';

            $sourceLanguage = 'uk'; // Исходный язык
            $targetLanguages = ['ru', 'en']; // Языки перевода

            $tr = new GoogleTranslate();

            foreach ($targetLanguages as $language) {
                $translation = $post->getTranslation($language)->one();
                if (!$translation) {
                    $translation = new PostsTranslate();
                    $translation->post_id = $post->id;
                    $translation->language = $language;
                }

                $tr->setSource($sourceLanguage);
                $tr->setTarget($language);

                $translation->title = $tr->translate($post->title ?? '');

                if (!empty($post->description)) {
                    if (strlen($post->description) < 5000) {
                        $translation->description = $tr->translate($post->description);
                    } else {
                        $description = $post->description;
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


                $translation->seo_title = $tr->translate($post->seo_title ?? '');
                $translation->seo_description = $tr->translate($post->seo_description ?? '');


               if ($translation->save()) {
    echo "$i  Статья $post->id переведена и сохранена $descrSave для $language.\n";
} else {
    echo "$i  Ошибка во время сохранения $post->id для $language.\n";
    print_r($translation->getErrors()); // вывод ошибок
}

            }
            $i++;
        }
    }

}
