<?php

use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\bootstrap5\LinkPager;
use common\models\Report;

/** @var yii\web\View $this */
/** @var backend\models\search\ActivePagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Reports');

$isMobile = Yii::$app->devicedetect->isMobile();

$reportSmallProblem = [
    Report::StatusDeliveryNotSelected(),
    Report::StatusPaymentNotSelected(),
    Report::DatePaymentNot(),
    Report::TypePaymentNot(),
    Report::NunberNot(),
    Report::TtnNot(),
];

$reportBigProblem = [
    Report::IncomingPriceNotSelected(),
    Report::StatusUnpaidMonth(),
    Report::NonNovaPay(),
];

$orderBigProblem = '<span class="indicator indicator__red"> !</span>';
$orderSmallProblem = '<span class="indicator indicator__yellow">! </span>';
$orderNoProblem = '';

$assistFlagBig = array_filter($reportBigProblem, fn($value) => $value !== null) ? $orderBigProblem : $orderNoProblem;
$assistFlagSmall = array_filter($reportSmallProblem, fn($value) => $value !== null) ? $orderSmallProblem : $orderNoProblem;

$btnPc =
    Html::a(Yii::t('app', 'Звіт за Період'), Url::to(['report/period-report']), ['class' => 'btn btn-secondary me-3']) .
    Html::a(Yii::t('app', 'Звіт по Prom'), Url::to(['report/prom-report']), ['class' => 'btn btn-prom me-3']) .
    Html::a(Yii::t('app', 'Звіт по Рекламі'), Url::to(['report/advertising-report']), ['class' => 'btn btn-success me-3']) .
    Html::a(Yii::t('app', 'Асистент ' . $assistFlagBig . $assistFlagSmall), Url::to(['report/assistant']), ['class' => 'btn btn-info me-3']) .
    Html::a(Yii::t('app', 'New +'), Url::to(['create']), ['class' => 'btn btn-primary me-3']);

$btnMob = Html::a(Yii::t('app', 'New +'), Url::to(['create']), ['class' => 'btn btn-primary me-3']);

?>

<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
            <div class="card">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'responsiveWrap' => false,
                    'tableOptions' => ['class' => 'table table-bordered text-center'],
                    'summary' => $isMobile ? false : "Показано <span class='summary-info'>{begin}</span> - <span class='summary-info'>{end}</span> из <span class='summary-info'>{totalCount}</span> Записей",
                    'panel' => [
                        'type' => 'warning',
                        'heading' => '<h3 class="panel-title"><i class="fas fa-globe"></i> ' . $this->title . '</h3>',
                        'headingOptions' => ['style' => 'height: 50px; margin-top: 10px'],
                        'before' => $isMobile ? $btnMob : $btnPc,
                        'after' =>
                            Html::a('<i class="fas fa-redo"></i> Обновити', ['index'], ['class' => 'btn btn-info']),
                    ],
                    'pager' => [
                        'class' => LinkPager::class,
                        'options' => ['class' => 'pagination justify-content-center'],
                        'maxButtonCount' => $isMobile ? 3 : 10,
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                        'prevPageLabel' => '<',
                        'nextPageLabel' => '>',
                    ],
                    'columns' => [
                        'number_order',
                        'platform',
                        [
                            'attribute' => 'order_status_id',
                            'label' => 'Доставка',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $statuses = [
                                    'Очікується',
                                    'Повернення',
                                    'Одержано',
                                    'Комплектується',
                                    'Доставляється',
                                    'Відміна',
                                ];

                                $colors = [
                                    'Очікується' => 'status-expected',
                                    'Повернення' => 'status-returned',
                                    'Одержано' => 'status-received',
                                    'Комплектується' => 'status-packing',
                                    'Доставляється' => 'status-delivering',
                                    'Відміна' => 'status-canceled',
                                ];

                                $options = '';
                                foreach ($statuses as $status) {
                                    $selected = $model->order_status_id === $status ? 'selected' : '';
                                    $options .= "<option value='{$status}' {$selected}>{$status}</option>";
                                }
                                $class = $colors[$model->order_status_id] ?? '';

                                return "<select class='form-control order-status-select {$class}' data-id='{$model->id}'>{$options}</select>";
                            },

                            'filter' => [
                                'Очікується' => 'Очікується',
                                'Повернення' => 'Повернення',
                                'Одержано' => 'Одержано',
                                'Комплектується' => 'Комплектується',
                                'Доставляється' => 'Доставляється',
                                'Відміна' => 'Відміна',
                            ],
                            'filterInputOptions' => ['class' => 'form-control', 'style' => 'width: 165px;'],
                        ],
                        [
                            'attribute' => 'sum',
                            'label' => 'Сума',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $sum = $model->getTotalSumm($model->id);

                                $formattedSum = Yii::$app->formatter->asDecimal($sum, 2);
                                return $sum < 0
                                    ? "<span style='color: red; font-weight: bold'>{$formattedSum}</span>"
                                    : "<span style='font-weight: bold'>{$formattedSum}</span>";
                            },
                        ],
                        [
                            'attribute' => 'package',
                            'label' => 'Пакування',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->getPackage($model->id);
                            },
                            'enableSorting' => true, // Включение сортировки
                        ],
                        [
                            'attribute' => 'fio',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<a href="' . Url::to(['report/view', 'id' => $model->id]) . '" style="white-space: nowrap; color: black;">'
                                    . $model->fio .
                                    '</a>';
                            },
                        ],
                        [
                            'attribute' => 'order_pay_ment_id',
                            'label' => 'Оплата',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $statuses = [
                                    'Повернення',
                                    'Оплачено',
                                    'Відміна',
                                    'Не оплачено',
                                ];

                                $colors = [
                                    'Повернення' => 'status-returned',
                                    'Оплачено' => 'status-received',
                                    'Не оплачено' => 'status-delivering',
                                    'Відміна' => 'status-canceled',
                                ];

                                $options = '';
                                foreach ($statuses as $status) {
                                    $selected = $model->order_pay_ment_id === $status ? 'selected' : '';
                                    $options .= "<option value='{$status}' {$selected}>{$status}</option>";
                                }
                                $class = $colors[$model->order_pay_ment_id] ?? '';

                                return "<select class='form-control order-payment-select {$class}' data-id='{$model->id}'>{$options}</select>";

                            },

                            'filter' => [
                                'Повернення' => 'Повернення',
                                'Оплачено' => 'Оплачено',
                                'Відміна' => 'Відміна',
                                'Не оплачено' => 'Не оплачено',
                            ],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['class' => 'form-control', 'style' => 'width: 140px;'],
                        ],
                        [
                            'attribute' => 'date_payment',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $formattedDate = !empty($model->date_payment)
                                    ? Yii::$app->formatter->asDate($model->date_payment, 'php:d-m-Y')
                                    : '';

                                return "<span style='white-space: nowrap;'>{$formattedDate}</span>";
                            },
                            'filterInputOptions' => ['class' => 'form-control', 'style' => 'width: 100px;'],
                        ],
                        [
                            'attribute' => 'ttn',
                            'label' => 'ТТН',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'delivery_service',
                            'filter' => false,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->getDeliveryLogo($model->delivery_service);
                            },
                        ],
                        [
                            'attribute' => 'date_delivery',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $formattedDate = !empty($model->date_delivery)
                                    ? Yii::$app->formatter->asDate($model->date_delivery, 'php:d-m-Y')
                                    : '';

                                return "<span style='white-space: nowrap;'>{$formattedDate}</span>";
                            },
                            'filterInputOptions' => ['class' => 'form-control', 'style' => 'width: 100px;'],
                        ],
                        'type_payment',
                        [
                            'attribute' => 'tel_number',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->getPhoneCut($model->tel_number);
                            },
                        ],
                        [
                            'attribute' => 'address',
                            'label' => 'Адреса доставки',
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'white-space: nowrap;'],
                            'contentOptions' => ['style' => 'white-space: nowrap;'],
                            'value' => function ($model) {
                                $short = StringHelper::truncate($model->address, 15);
                                $full = Html::encode($model->address);
                                $id = 'modal-address-' . $model->id;

                                return
<<<HTML
<span data-bs-toggle="modal" data-bs-target="#$id" style="cursor: pointer; color: #646970;">
    $short
</span>

<div class="modal fade" id="$id" tabindex="-1" aria-labelledby="label-$id" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label-$id">Повна адреса доставки</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
      </div>
      <div class="modal-body">
        <pre style="white-space: pre-wrap;">$full</pre>
      </div>
    </div>
  </div>
</div>
HTML;
                            },
                        ],
                        [
                            'attribute' => 'products_order',
                            'label' => 'Товари',
                            'format' => 'raw',
                            'filter' => Html::activeTextInput($searchModel, 'products_order', ['class' => 'form-control', 'style' => 'width: 200px;']),
                            'value' => function ($model) {
                                $content = implode(', ', array_map(fn($item) => $item->product_name, $model->reportItems));
                                $id = 'details-' . $model->id; // Уникальный идентификатор
                                return <<<HTML
                                            <button type="button" 
                                            class="btn btn-sm btn-outline-info toggle-content" 
                                            data-target="#{$id}">+</button>
                                            <div id="{$id}" class="hidden-content" style="display: none;">{$content}</div>
                                        HTML;
                            },
                        ],
                        [
                            'attribute' => 'CountOrders',
                            'label' => 'Замовлень',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->getCountOrders($model->tel_number);
                            },
                        ],
                        [
                            'attribute' => 'date_order',
                            'filter' => false,
                            'label' => 'Створення замовлення',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $formattedDate = !empty($model->date_order)
                                    ? Yii::$app->formatter->asDate($model->date_order, 'php:d-m-Y')
                                    : '';

                                return "<span style='white-space: nowrap;'>{$formattedDate}</span>";
                            },
                        ],

                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, Report $model) {
                                return Url::toRoute([$action, 'id' => $model->id, 'selection' => $model->id]);
                            }
                        ],
                    ],
                ]);
                $this->registerJs(<<<JS
    document.querySelectorAll('.toggle-content').forEach(button => {
        button.addEventListener('click', function () {
            const target = document.querySelector(this.getAttribute('data-target'));
            if (target.style.display === 'none') {
                target.style.display = 'block';
                this.textContent = '-';
            } else {
                target.style.display = 'none';
                this.textContent = '+';
            }
        });
    });
JS
                );

                ?>
            </div>
        </div>
    </div>
</div>
<style>
    .summary-info {
        font-size: 18px;
        font-weight: bold;
        color: #00050b;
    }

    .indicator {
        height: 15px;
        font-size: 16px;
        padding: 1px 9px;
        margin-left: 5px;
        border-radius: 1000px;
        position: relative;
        font-weight: 700;
    }

    .indicator__red {
        background: #ed2e34;
        color: #f6f7f8;
    }

    .indicator__yellow {
        background: #fbe720;
        color: #3d464d;
    }

    .hidden-content {
        margin-top: 10px;
        padding: 15px;
    }

    .status-expected {
        background-color: #0a7cd4b3 !important;
        color: #ffffff;
    }

    .status-returned {
        background-color: #ff0000ab !important;
        color: #fff;
    }

    .status-received {
        background-color: #429b03b3 !important;
        color: #fff;
    }

    .status-packing {
        background-color: #e7c306b3 !important;
        color: #fff;
    }

    .status-delivering {
        background-color: #f97304d6 !important;
        color: #fff;
    }

    .status-canceled {
        background-color: #4f4c4c78 !important;
        color: #fff;
    }

</style>

<?php
$js = <<<JS
function getStatusColorClass(status) {
    const map = {
        'Очікується': 'status-expected',
        'Повернення': 'status-returned',
        'Одержано': 'status-received',
        'Комплектується': 'status-packing',
        'Доставляється': 'status-delivering',
        'Відміна': 'status-canceled'
    };
     return map[status] || '';
}

$(document).on('change', '.order-status-select', function() {
    var \$this = $(this);
    var id = \$this.data('id');
    var status = \$this.val();

    // Сначала удалим все bg-*
    \$this.removeClass('status-expected status-returned status-received status-packing status-delivering status-canceled');

    // Добавим актуальный класс
    \$this.addClass(getStatusColorClass(status));

    // Отправим на сервер
    $.ajax({
        url: '/admin/uk/report/ajax-update-order-status',
        type: 'POST',
        data: {
            id: id,
            status: status
            // _csrf: yii.getCsrfToken()
        },
        success: function(res) {
            if (res.status === 'ok') {
                showMessage(res.message, 'success');
            } else {
                showMessage(res.message, 'danger');
            }
        },
        error: function() {
            showMessage('Помилка при збереженні!', 'danger');
        }
    });
});

function getPaymentColorClass(status) {
    const map = {
        'Повернення': 'status-returned',
        'Оплачено': 'status-received',
        'Не оплачено': 'status-delivering',
        'Відміна': 'status-canceled'
    };
     return map[status] || '';
}

$(document).on('change', '.order-payment-select', function() {
    var \$this = $(this);
    var id = \$this.data('id');
    var status = \$this.val();

    // Сначала удалим все bg-*
    \$this.removeClass('status-returned status-received status-delivering status-canceled');

    // Добавим актуальный класс
    \$this.addClass(getPaymentColorClass(status));

    // Отправим на сервер
    $.ajax({
        url: '/admin/uk/report/ajax-update-order-payment',
        type: 'POST',
        data: {
            id: id,
            status: status
            // _csrf: yii.getCsrfToken()
        },
        success: function(res) {
            if (res.status === 'ok') {
                showMessage(res.message, 'success');
            } else {
                showMessage(res.message, 'danger');
            }
        },
        error: function() {
            showMessage('Помилка при збереженні!', 'danger');
        }
    });
});

function showMessage(message, type = 'success') {
    let html = '<div id="flash-message" class="alert alert-' + type + '" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">' + message + '</div>';
    $('body').append(html);
    setTimeout(function() {
        $('#flash-message').fadeOut(function() {
            $(this).remove();
        });
    }, 2000);
}
JS;

$this->registerJs($js);
?>

