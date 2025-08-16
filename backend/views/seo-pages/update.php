<?php

/** @var yii\web\View $this */
/** @var common\models\SeoPages $model */

$this->title = Yii::t('app', 'Update Seo Pages: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seo Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="seo-pages-update">

    <?= $this->render('_form', [
        'model' => $model,
        'translateRu' => $translateRu,
    ]) ?>

</div>
