<?php
namespace frontend\components;

use codemix\localeurls\UrlManager as BaseUrlManager;
use Yii;

class MyUrlManager extends BaseUrlManager
{
    /**
     * Переопределяем метод, который делает редирект на URL с языком
     */
    protected function redirect($url)
    {
        Yii::$app->response->redirect($url, 301)->send();
        Yii::$app->end();
    }
}
