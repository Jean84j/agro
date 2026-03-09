<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\SearchWords $model */

$this->title = 'Create Search Words';
$this->params['breadcrumbs'][] = ['label' => 'Search Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="search-words-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
