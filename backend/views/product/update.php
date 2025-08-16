<?php

/** @var yii\web\View $this */
/** @var common\models\shop\Product $model */

$this->title = Yii::t('app', 'Update Product: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = $model->name;
?>

<?= $this->render('_form', [
    'model' => $model,
    'data' => $data,
    'dataRu' => $dataRu,
    'translateRu' => $translateRu,
    'faq' => $faq,
    'variants' => $variants,

]) ?>

