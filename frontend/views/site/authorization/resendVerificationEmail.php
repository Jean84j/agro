<?php

/** @var yii\web\View$this  */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\ResetPasswordForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Надіслати лист із підтвердженням ще раз';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container site-resend-verification-email">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Будь ласка, вкажіть свою електронну адресу. На неї буде надіслано лист із підтвердженням.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
