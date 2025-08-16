<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\AuxiliaryCategoriesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="auxiliary-categories-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'parentId') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'pageTitle') ?>

    <?= $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'visibility') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'metaDescription') ?>

    <?php // echo $form->field($model, 'svg') ?>

    <?php // echo $form->field($model, 'prefix') ?>

    <?php // echo $form->field($model, 'object') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
