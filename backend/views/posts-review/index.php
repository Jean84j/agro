<?php

use common\models\PostsReview;
use yii\bootstrap5\LinkPager;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\search\PostsReviewSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Posts Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <?= $this->render('@backend/views/_partials/breadcrumbs'); ?>
                    <div class="col-auto d-flex"><a href="<?= Url::to(['create']) ?>"
                                                    class="btn btn-primary"><?= Yii::t('app', 'Create Review') ?></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="sa-divider"></div>
                <div class="container">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pager' => [
                            'class' => LinkPager::class,
                            'options' => ['class' => 'pagination'],
//                            'maxButtonCount' => 5,
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

//                            'id',
                            [
                                'attribute' => 'created_at',
//                                'filter' => false,
                                'contentOptions' => ['style' => 'width: 100px'],
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDate($model->created_at, 'short');
                                },
                            ],
                            [
                                'attribute' => 'post_id',
//                                'filter' => false,
                                'value' => function ($model) {
                                    return $model->getPostName($model->post_id);
                                },
                            ],

                            [
                                'attribute' => 'rating',
                                'format' => 'raw',
                                'filter' => false,
                                'contentOptions' => ['style' => 'width: 115px'],
                                'value' => function ($model) {
                                    return $model->getStarRating($model->rating);
                                },
                            ],
                            [
                                'attribute' => 'name',
                                'format' => 'raw',
                                'filter' => false,
                                'value' => function ($model) {
                                    return Html::encode($model->name);
                                },
                            ],
                            // 'email:email',
                            [
                                'attribute' => 'message',
                                'format' => 'raw',
                                'filter' => false,
                                'value' => function ($model) {
                                    return Html::encode($model->message);
                                },
                            ],
                            [
                                'class' => ActionColumn::class,
                                'urlCreator' => function ($action, PostsReview $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
