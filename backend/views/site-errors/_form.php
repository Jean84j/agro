<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SiteErrors $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="site-errors-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ip_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_page')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_agent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_from')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_visit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_serv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'other')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
