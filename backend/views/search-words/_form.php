<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\SearchWords $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="search-words-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'counts_query')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
