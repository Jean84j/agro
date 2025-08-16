<?php

use common\models\Posts;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\search\PostsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Posts');

?>

<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
            <div class="card">
                <div class="sa-divider"></div>
                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'responsiveWrap' => false,
                    'summary' => Yii::$app->devicedetect->isMobile() ? false : "Показано <span class='summary-info'>{begin}</span> - <span class='summary-info'>{end}</span> из <span class='summary-info'>{totalCount}</span> Записей",
                    'panel' => [
                        'type' => 'warning',
                        'heading' => '<h3 class="panel-title"><i class="fas fa-globe"></i> ' . $this->title . '</h3>',
                        'headingOptions' => ['style' => 'height: 60px; margin-top: 10px'],

                        'before' => Html::a(Yii::t('app', 'New post'), Url::to(['create']), ['class' => 'btn btn-primary']),


                        'after' => Html::a('<i class="fas fa-redo"></i> Обновити', ['index'], ['class' => 'btn btn-info']),
                    ],
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
                        [
                            'attribute' => 'image',
                            'filter' => false,
                            'format' => 'html',
                            'value' => function ($model) {
                                return Html::img(Yii::$app->request->hostInfo . '/posts/' . $model->medium);
                            },
                        ],
                        [
                            'attribute' => 'date_public',
                            'label' => 'Опубліковано',
                            'filter' => false,
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model->date_public, 'short');
                            },
                            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                        ],
                        [
                            'attribute' => 'date_updated',
                            'label' => 'Відредаговано',
                            'filter' => false,
                            'value' => function ($model) {
                                if ($model->date_updated) {
                                    return Yii::$app->formatter->asDate($model->date_updated, 'short');
                                } else {
                                    return Yii::$app->formatter->asDate($model->date_public, 'short');
                                }
                            },
                            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                        ],
                        [
                            'attribute' => 'date_view',
                            'label' => 'Переглянуто',
                            'format' => 'raw',
                            'filter' => false,
                            'value' => function ($model) {
                                $dateView = $model->getPostDateView($model->slug);

                                if ($dateView) {
                                    return Yii::$app->formatter->asDate($dateView, 'short');
                                } else {
                                    return '<span 
                                            style="background-color: rgba(255,0,0,0.64); font-weight: bold; color: white; padding: 3px 5px; border-radius: 50rem"
                                            >
                                            Без переглядів
                                            </span>';
                                }
                            },
                            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                        ],
                        [
                            'attribute' => 'views',
                            'label' => 'Перегляди',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $countViews = $model->getPostViews($model->slug);
                                return '<span class="badge-sa-theme-user badge-sa-pill">' . $countViews . '</span>';
                            },
                            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                        ],
                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                        ],
                        [
                            'attribute' => 'products',
                            'label' => 'Товар',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $countProducts = $model->getCountProducts($model->id);

                                return '<span class="badge-sa-pill" style="color: rgba(255,255,255,0.98); background: rgba(234,60,60,0.58)">' . $countProducts . '</span>';
                            },
                            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                        ],

                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, Posts $model) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>


