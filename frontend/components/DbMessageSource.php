<?php

namespace frontend\components;

use yii\i18n\MessageSource;
use common\models\Translations;

class DbMessageSource extends MessageSource
{
    // Переопределение метода для загрузки сообщений из базы данных
    protected function loadMessages($category, $language)
    {
        // Получаем все переводы для конкретной категории и языка из базы данных
        $translations = Translations::find()
            ->where(['category' => $category, 'language' => $language])
            ->asArray()
            ->all();

        $messages = [];
        foreach ($translations as $translation) {
            $messages[$translation['message']] = $translation['translation'];
        }

        return $messages;
    }
}

