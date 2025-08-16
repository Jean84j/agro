<?php

use common\models\IpBot;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\search\IpBotSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Ip Bots');
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
            <div class="card">
                <?php echo Html::beginForm(['check-delete']); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'responsiveWrap' => false,
                    'summary' => Yii::$app->devicedetect->isMobile() ? false : "Показано <span class='summary-info'>{begin}</span> - <span class='summary-info'>{end}</span> из <span class='summary-info'>{totalCount}</span> Записей",
                    'panel' => [
                        'type' => 'warning',
                        'heading' => '<h3 class="panel-title"><i class="fas fa-globe"></i> ' . $this->title . '</h3>',
                        'headingOptions' => ['style' => 'height: 60px; margin-top: 10px'],
                        'before' => Html::a(Yii::t('app', 'New +'), Url::to(['create']), ['class' => 'btn btn-primary']),
                        'after' =>
                            Html::a('<i class="fas fa-redo"></i> Обновити', ['index'], ['class' => 'btn btn-info']),
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
                        [
                            'attribute' => 'id',
                            'format' => 'raw',
                            'filter' => false,
                            'contentOptions' => ['style' => 'width: 50px; text-align: center;']
                        ],
                        [
                            'attribute' => 'ip',
                            'label' => 'IP Адрес',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 150px; text-align: center;']
                        ],
                        [
                            'attribute' => 'isp',
                            'label' => 'Провайдер',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'comment',
                            'label' => 'Комментарий',
                            'format' => 'raw',
                            'value' => fn($model) => $model->comment ?: '',
                        ],
                        [
                            'attribute' => 'blocking',
                            'label' => 'Заблокирован',
                            'format' => 'boolean',
                            'filter' => true,
                            'contentOptions' => function ($model) {
                                return [
                                    'style' => $model->blocking
                                        ? 'width: 100px; text-align: center; background-color: #eb1c1c99; color: white;'
                                        : 'width: 100px; text-align: center;background-color: #43ed43b3; color: white;',
                                ];
                            },
                        ],

                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, IpBot $model) {
                                return Url::toRoute([$action, 'id' => $model->id, 'selection' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
                <?php echo Html::endForm(); ?>
            </div>
        </div>
    </div>
</div>
