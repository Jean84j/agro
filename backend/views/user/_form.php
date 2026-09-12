<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form container mt-5">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col">
            <?= $form->field($model, 'username')->textInput() ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'role')->dropDownList([
                User::ROLE_ADMIN => 'Адміністратор',
                User::ROLE_MANAGER => 'Менеджер',
                User::ROLE_USER => 'Користувач',
            ]) ?>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col">
            <?= $form->field($model, 'status')->dropDownList([
                User::STATUS_INACTIVE => 'Неактивный',
                User::STATUS_ACTIVE => 'Активный',
                User::STATUS_DELETED => 'Удаленный',
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'password', [
                'template' => "{label}\n<div class=\"input-group\">{input}<button type=\"button\" class=\"btn btn-outline-secondary\" id=\"password-toggle\">👁️</button></div>\n{error}",
                'options' => ['class' => 'mb-3'],
            ])->passwordInput([
                'id' => 'password-input',
            ])->label('Password') ?>
        </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success m-5']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    document.getElementById('password-toggle').addEventListener('click', function () {
        const password = document.getElementById('password-input');

        if (password.type === 'password') {
            password.type = 'text';
            this.textContent = '🙈';
        } else {
            password.type = 'password';
            this.textContent = '👁️';
        }
    });
</script>
