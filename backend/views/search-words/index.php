<?php

use backend\models\SearchWords;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\SearchWords $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Search Words';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="search-words-index container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'word',
            'counts_query',
            [
                'class' => ActionColumn::class(),
                'urlCreator' => function ($action, SearchWords $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
