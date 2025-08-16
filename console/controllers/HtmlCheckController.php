<?php

namespace console\controllers;

use common\models\shop\Product;
use common\models\shop\ProductsTranslate;
use yii\console\Controller;
use yii\helpers\Console;


class HtmlCheckController extends Controller
{
    /**
     * Перевірка HTML полів у всіх товарах
     */
    public function actionIndex()
    {
        $products = ProductsTranslate::find()
            ->select(['product_id', 'name', 'description'])
            ->where(['language' => 'ru'])
            ->all();

        $hasErrors = false;
        $i = 1;

        Console::output(Console::ansiFormat(str_repeat('=', 60), [
            Console::FG_GREEN, Console::BOLD
        ]));
        Console::output(Console::ansiFormat(str_repeat('=', 60), [
            Console::FG_RED, Console::BOLD
        ]));
        Console::output(Console::ansiFormat(str_repeat('=', 60), [
            Console::FG_GREEN, Console::BOLD
        ]));



        foreach ($products as $product) {
            $result = $this->validateHtml($product->description);

            if (!$result['success']) {
                $hasErrors = true;
                Console::output(Console::ansiFormat(
                    "❌ Проблеми в товарі [ID: {$product->product_id}] «{$product->name}»:",
                    [Console::FG_YELLOW, Console::BOLD]
                ));

                foreach ($result['errors'] as $error) {
                    Console::output("   - $error");
                }
                Console::output("");
                Console::output(Console::ansiFormat(str_repeat('* ', 20), [
                    Console::FG_GREEN, Console::BOLD
                ]));
                Console::output("");
                $i++;
            }
        }

        if (!$hasErrors) {
            Console::output("✅ Вся HTML-розмітка валідна.");
        }
        Console::output("->  {$i}");
    }

    /**
     * Перевірка HTML-контенту
     */
    private function validateHtml($html)
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();

        // Додаємо заголовок, щоб уникнути помилок кодування
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();
        libxml_clear_errors();

        if (empty($errors)) {
            return ['success' => true];
        }

        $messages = [];
        foreach ($errors as $error) {
            $messages[] = trim($error->message) . " (рядок {$error->line}, колонка {$error->column})";
        }

        return [
            'success' => false,
            'errors' => $messages
        ];
    }
}
