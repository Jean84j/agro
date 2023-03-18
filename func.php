<?php
function debug($arr)
{
    \yii\helpers\VarDumper::dump($arr, 10, true);
}
