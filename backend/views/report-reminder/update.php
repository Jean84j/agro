<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ReportReminder $model */

$this->title = 'Update Report Reminder: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Report Reminders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-reminder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
