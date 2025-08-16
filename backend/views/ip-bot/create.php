<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\IpBot $model */

$this->title = Yii::t('app', 'Create Ip Bot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ip Bots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ip-bot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
