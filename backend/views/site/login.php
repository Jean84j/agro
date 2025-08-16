<?php

use yii\bootstrap5\ActiveForm;
use common\models\shop\ActivePages;

ActivePages::setActiveUser();

?>
<div class="min-h-100 p-0 p-sm-6 d-flex align-items-stretch">
    <div class="card w-25x flex-grow-1 flex-sm-grow-0 m-sm-auto">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="card-body p-sm-5 m-sm-3 flex-grow-0">
            <div class="mb-4">
                <label class="form-label">Логін</label>
                <input type="text" id="input-username" name="LoginForm[username]" class="form-control form-control-lg"/>
            </div>
            <div class="mb-4">
                <label class="form-label">Пароль</label>
                <input type="password" id="input-password" name="LoginForm[password]" class="form-control form-control-lg"/>
            </div>
            <div class="mb-4 row py-2 flex-wrap">
                
            </div>
            <div>
                <button type="submit" id="submit-btn" class="btn btn-primary btn-lg w-100" disabled>Увійти</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$script = <<<JS
function validateInputs() {
    const username = document.getElementById('input-username').value;
    const password = document.getElementById('input-password').value;
    const btn = document.getElementById('submit-btn');
    btn.disabled = !(username.length >= 5 && password.length >= 5);
}

document.getElementById('input-username').addEventListener('input', validateInputs);
document.getElementById('input-password').addEventListener('input', validateInputs);
JS;
$this->registerJs($script);
?>
