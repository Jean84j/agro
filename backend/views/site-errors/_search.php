<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\SearchSiteErrors $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="site-errors-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ip_user') ?>

    <?= $form->field($model, 'url_page') ?>

    <?= $form->field($model, 'user_agent') ?>

    <?= $form->field($model, 'client_from') ?>

    <?php // echo $form->field($model, 'date_visit') ?>

    <?php // echo $form->field($model, 'status_serv') ?>

    <?php // echo $form->field($model, 'other') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
