<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 *
 */
class BaseBackendController extends Controller
{
    public function beforeAction($action)
    {
        // Разрешаем страницу входа и страницу ошибки
        if (in_array($action->id, ['login', 'error'], true)) {
            return parent::beforeAction($action);
        }

        // Не авторизован
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        // Нет прав на backend
        if (!in_array((int)Yii::$app->user->identity->role, [2, 3], true)) {
            return $this->redirect(['/site/login']);
        }

        return parent::beforeAction($action);
    }
}
