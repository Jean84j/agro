<?php


namespace backend\widgets;


class ActiveUsers extends \yii\base\Widget
{
    public function init() {

        parent::init();

    }

    public function run() {

        return $this->render('active-users');
    }

}
