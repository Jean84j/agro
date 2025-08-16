<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Translations $model */

$this->title = Yii::t('app', 'Create Translations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
