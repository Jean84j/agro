<?php

/** @var yii\web\View $this */
/** @var common\models\Orders\OrderProvider $model */

$this->title = Yii::t('app', 'Create Order Provider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Providers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-provider-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
