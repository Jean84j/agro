<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Delivery $model */

$this->title = Yii::t('app', 'Update Delivery: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deliveries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="container delivery-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
