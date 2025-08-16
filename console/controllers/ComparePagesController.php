<?php

namespace console\controllers;

use common\models\shop\ActivePages;
use yii\console\Controller;
use yii\helpers\Console;


class ComparePagesController extends Controller
{
    public function actionRun()
    {
        // Отримуємо всі записи, упорядковані за id
        $pages = ActivePages::find()
            ->select(['id', 'ip_user', 'url_page'])
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->all();

        if (count($pages) < 2) {
            Console::output("Недостатньо записів для порівняння.");
            return;
        }

        $matchedIds = [];

        for ($i = 0; $i < count($pages) - 1; $i++) {
            $current = $pages[$i];
            $next = $pages[$i + 1];

            if ($current['ip_user'] === $next['ip_user'] && $current['url_page'] === $next['url_page']) {
                $matchedIds[] = $current['id'];

                Console::output(Console::ansiFormat(
                    "✔ Збіг: ID {$current['id']} та ID {$next['id']} (IP: {$current['ip_user']}, URL: {$current['url_page']})",
                    [Console::FG_GREEN]
                ));
            }
        }
        // Підсумок
        Console::output("\n🔎 Збіги знайдено: " . count($matchedIds));

        // Видалення знайдених записів
        $deleted = ActivePages::deleteAll(['id' => $matchedIds]);

        Console::output(Console::ansiFormat(
            "\n🗑️ Видалено записів: {$deleted}",
            [Console::FG_RED, Console::BOLD]
        ));
    }
}
