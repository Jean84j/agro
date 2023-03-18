<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Contact $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tel_primary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tel_second')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hours_work')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coments')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
