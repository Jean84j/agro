<?php

use yii\helpers\VarDumper;

function debug($arr)
{
    VarDumper::dump($arr, 10, true);
}

// **** Запись переменных в файл
function debugInFile($data)
{
    $filePath = Yii::getAlias('@runtime/debug_ajax.txt');

    $newEntry = "[" . date('Y-m-d H:i:s') . "]\n" . print_r($data, true) . "\n-------------------\n";

    $existingContent = file_exists($filePath) ? file_get_contents($filePath) : '';

    file_put_contents($filePath, $newEntry . $existingContent);
}