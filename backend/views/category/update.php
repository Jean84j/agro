<?php


/** @var yii\web\View $this */
/** @var common\models\shop\Category $model */

$this->title = Yii::t('app', 'Update Category: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>  Yii::t('app', 'Category') . ": " . $model->name];
//$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?= $this->render('_form', [
    'model' => $model,
    'translateRu' => $translateRu,
]) ?>

