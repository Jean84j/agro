<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\shop\AuxiliaryCategories $model */

$this->title = Yii::t('app', 'Create Auxiliary Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auxiliary Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auxiliary-categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
