<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ReportReminder $model */

$this->title = 'Create Report Reminder';
$this->params['breadcrumbs'][] = ['label' => 'Report Reminders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-reminder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
