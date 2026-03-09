<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\SearchWords $model */

$this->title = 'Update Search Words: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Search Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="search-words-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
