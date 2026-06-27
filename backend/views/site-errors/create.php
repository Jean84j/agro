<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SiteErrors $model */

$this->title = 'Create Site Errors';
$this->params['breadcrumbs'][] = ['label' => 'Site Errors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-errors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
