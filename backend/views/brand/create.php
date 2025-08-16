<?php

/** @var yii\web\View $this */
/** @var common\models\shop\Brand $model */

$this->title = $this->title = Yii::t('app', 'Create Brand');
$this->params['breadcrumbs'][] = ['label' => 'Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
