<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Competitors\Competitors $model */

$this->title = 'Update Competitors: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Competitors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="competitors-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'competitors' => $competitors,
    ]) ?>

</div>
