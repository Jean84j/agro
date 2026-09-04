<?php

use yii\helpers\VarDumper;

function debug($arr)
{
    VarDumper::dump($arr, 10, true);
}

// **** Запись переменных в файл
function debugInFile($data, $maxKilobytes = 500)
{
    $filePath = Yii::getAlias('@runtime/debug_ajax.txt');

    $newEntry = "[" . date('Y-m-d H:i:s') . "]\n" . print_r($data, true) . "\n-------------------\n";

    $existingContent = file_exists($filePath) ? file_get_contents($filePath) : '';
    $combinedContent = $newEntry . $existingContent;

    $maxBytes = $maxKilobytes * 1024;

    if (mb_strlen($combinedContent, '8bit') > $maxBytes) {
        $combinedContent = mb_strcut($combinedContent, 0, $maxBytes, '8bit');
    }

    file_put_contents($filePath, $combinedContent);
}