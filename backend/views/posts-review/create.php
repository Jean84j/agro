<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PostsReview $model */

$this->title = Yii::t('app', 'Create Posts Review');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-review-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
