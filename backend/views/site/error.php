<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception*/

use yii\helpers\Html;
use yii\helpers\Url;

if (Yii::$app->user->isGuest) {
    Yii::$app->response->redirect(['/'])->send();
    Yii::$app->end();
}

$this->title = $name;

?>
<!-- sa-app__body -->
<div id="top" class="sa-app__body">
    <div class="sa-error">
        <div class="sa-error__background-text">Oops! <?= Html::encode($name) ?></div>
        <div class="sa-error__content">
            <h1 class="sa-error__title"><?=$message?></h1>

            <a class="btn btn-secondary btn-sm" href="<?=Url::to('/admin/')?>">На головну</a>
        </div>
    </div>
</div>
<!-- sa-app__body / end -->
