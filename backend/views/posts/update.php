<?php

/** @var yii\web\View $this */
/** @var common\models\Posts $model */

$this->title = Yii::t('app', 'Update Posts: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="posts-update">

    <?= $this->render('_form', [
        'model' => $model,
        'translateRu' => $translateRu,
    ]) ?>

</div>
