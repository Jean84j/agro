<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\competitors\Competitors $model */

$this->title = 'Create Competitors';
$this->params['breadcrumbs'][] = ['label' => 'Competitors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competitors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
