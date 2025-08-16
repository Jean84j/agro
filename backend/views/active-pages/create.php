<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\shop\ActivePages $model */

$this->title = Yii::t('app', 'Create Active Pages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Active Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="active-pages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
