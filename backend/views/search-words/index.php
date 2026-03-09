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
<div class="search-words-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Search Words', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SearchWords $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
