<?php

use common\models\Messages;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\MessagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <nav class="mb-2" aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-sa-simple">
                                <?php echo Breadcrumbs::widget([
                                    'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                                    'homeLink' => [
                                        'label' => Yii::t('app', 'Home'),
                                        'url' => Yii::$app->homeUrl,
                                    ],
                                    'links' => $this->params['breadcrumbs'] ?? [],
                                ]); ?>
                            </ol>
                        </nav>
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

                            [
                                'attribute' => 'created_at',
                                'filter' => false,
                                'value' => function($model){
                                    return Yii::$app->formatter->asDate($model->created_at, 'long');
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
                            'email:email',
                            [
                                'attribute' => 'subject',
                                'format' => 'raw',
                                'filter' => false,
                                'value' => function ($model) {
                                    return Html::encode($model->subject);
                                },
                            ],
                            [
                                'attribute' => 'message',
                                'format' => 'raw',
                                'filter' => false,
                                'value' => function ($model) {
                                    return Html::encode($model->message);
                                },
                            ],
                            'comment:raw',
                            'viewed:boolean',
                            [
                                'class' => ActionColumn::class,
                                'urlCreator' => function ($action, Messages $model, $key, $index, $column) {
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
