<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Вітаю <?= $user->username ?>,

Перейдіть за посиланням нижче, щоб підтвердити свою електронну адресу:

<?= $verifyLink ?>
