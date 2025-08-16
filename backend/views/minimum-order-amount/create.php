<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\shop\MinimumOrderAmount $model */

$this->title = Yii::t('app', 'Create Minimum Order Amount');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Minimum Order Amounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="minimum-order-amount-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
