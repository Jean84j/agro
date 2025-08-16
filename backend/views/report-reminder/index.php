<?php

use common\models\ReportReminder;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\web\View;

/** @var yii\web\View $this */
/** @var backend\models\search\ReportReminder $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Report Reminders';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="top" class="sa-app__body">
        <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
            <div class="container" style="max-width: 1623px">
                <div class="card">
                    <div class="sa-divider"></div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => null,
                        'responsiveWrap' => false,
                        'panel' => [
                            'type' => 'warning',
                            'heading' =>
                            '<h3 class="panel-title"><i class="fas fa-bell"></i> Нагадування <h3>',
                            'headingOptions' => ['style' => 'height: 60px; margin-top: 10px'],
                            'before' => false,
                            'after' =>
                                Html::a('<i class="fas fa-redo"></i> Обновити', ['index'], ['class' => 'btn btn-info']),
                            'footer' => false, // <<< отключает нижнюю часть карточки
                            ],
                        'rowOptions' => function ($model) {
                            $currentDate = new DateTimeImmutable(date('Y-m-d'));
                            $eventDate = new DateTimeImmutable(date('Y-m-d', $model->date));
                            $days = (int)$currentDate->diff($eventDate)->format('%r%a');

                            if ($days < 0) {
                                return ['style' => 'background-color: #ed0b0bc2;'];
                            }
                            if ($days === 0) {
                                return ['style' => 'background-color: #dd4b4b96;'];
                            }
                            if ($days === 1) {
                                return ['style' => 'background-color: #f1a54cbd;'];
                            }
                            if ($days === 2) {
                                return ['style' => 'background-color: #1cf12a9e;'];
                            }

                            return [];
                        },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Замовлення',
                                'value' => function ($model) {
                                    return $model->report ? $model->report->number_order : '(немає)';
                                },
                                'width' => '100px',
                            ],
                            [
                                'attribute' => 'date',
                                'label' => 'Дата',
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDate($model->date, 'php:d.m.Y');
                                },
                                'filter' => false,
                                'hAlign' => 'center',
                                'width' => '120px',
                            ],
                            [
                                'label' => 'ФІО',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->report) {
                                        return Html::a(
                                            Html::encode($model->report->fio),
                                            ['report/view', 'id' => $model->report->id],
                                            ['style' => 'white-space: nowrap; color: black;']
                                        );
                                    }
                                    return '(не вказано)';
                                },
                                'hAlign' => 'center',
                            ],
                            [
                                'attribute' => 'event',
                                'label' => 'Подія',
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'status',
                                'label' => 'Статус',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $statusOptions = [
                                        1 => 'Активний',
                                        0 => 'Не активний',
                                    ];

                                    $colors = [
                                        1 => 'background-color: #05cd35; color: #0d100e;', // зелений
                                        0 => 'background-color: #e90e22; color: #f5efef;', // червоний
                                    ];

                                    return Html::dropDownList(
                                        'status',
                                        $model->status,
                                        $statusOptions,
                                        [
                                            'class' => 'form-select form-select-sm change-status',
                                            'data-id' => $model->id,
                                            'style' => $colors[$model->status] ?? '',
                                        ]
                                    );
                                },
                                'width' => '130px',
                                'filter' => false,
                            ],

                            [
                                'attribute' => 'comment',
                                'label' => 'Коментар',
                                'filter' => false,
                            ],
                            [
                                'class' => ActionColumn::class,
                                'template' => '{delete}',
                                'urlCreator' => function ($action, ReportReminder $model) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php
$script = <<< JS

 $(document).on('change', '.change-status', function () {
    let id = $(this).data('id');
    let status = $(this).val();

    $.ajax({
        url: '/admin/uk/report-reminder/change-status',
        type: 'POST',
        data: {
            id: id,
            status: status,
            _csrf: yii.getCsrfToken()
        },
        success: function (response) {
            if (response.success) {
                console.log('Статус оновлено');
                location.reload(); // перезавантаження сторінки
            } else {
                alert('Помилка при оновленні');
            }
        },
        error: function () {
            alert('Помилка запиту');
        }
    });
});

JS;

$this->registerJs($script, View::POS_END);
?>