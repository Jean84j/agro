<?php

/** @var yii\web\View $this */
/** @var common\models\SeoPages $model */

$this->title = Yii::t('app', 'Create Seo Pages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seo Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-pages-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
