<?php

/** @var yii\web\View $this */
/** @var common\models\shop\PropertiesName $model */

$this->title = Yii::t('app', 'Create Properties Name');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties Names'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="properties-name-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
