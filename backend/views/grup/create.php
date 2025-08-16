<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\shop\Grup $model */

$this->title = Yii::t('app', 'Create Grup');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Grups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
