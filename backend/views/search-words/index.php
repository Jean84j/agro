<?php

use backend\models\SearchWords;
use yii\bootstrap5\LinkPager;
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => LinkPager::class,
            'options' => ['class' => 'pagination justify-content-center'],
            'maxButtonCount' => Yii::$app->devicedetect->isMobile() ? 3 : 10,
            'firstPageLabel' => '<<',
            'lastPageLabel' => '>>',
            'prevPageLabel' => '<',
            'nextPageLabel' => '>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'word',
            'counts_query',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, SearchWords $model) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
