<?php

namespace frontend\controllers;

use yii\web\Controller;


class ContactController extends Controller
{
    public function actionView(): string
    {

        return $this->render('view');

    }

}
