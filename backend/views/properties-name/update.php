<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\shop\PropertiesName $model */

$this->title = Yii::t('app', 'Update Properties Name: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties Names'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="properties-name-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'translateRu' => $translateRu,
    ]) ?>

</div>
