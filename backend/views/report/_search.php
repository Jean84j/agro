<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\ReportSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'platform') ?>

    <?= $form->field($model, 'number_order') ?>

    <?= $form->field($model, 'date_order') ?>

    <?= $form->field($model, 'date_delivery') ?>

    <?php // echo $form->field($model, 'number_order_1c') ?>

    <?php // echo $form->field($model, 'date_payment') ?>

    <?php // echo $form->field($model, 'price_delivery') ?>

    <?php // echo $form->field($model, 'type_payment') ?>

    <?php // echo $form->field($model, 'fio') ?>

    <?php // echo $form->field($model, 'tel_number') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'delivery_service') ?>

    <?php // echo $form->field($model, 'ttn') ?>

    <?php // echo $form->field($model, 'order_status_id') ?>

    <?php // echo $form->field($model, 'order_pay_ment_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
