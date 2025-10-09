<?php

/** @var backend\models\Report $model */
/** @var backend\models\Report $bigAllSum */
/** @var backend\models\Report $bigSum */
/** @var backend\models\Report $bigIncomingPriceSum */
/** @var backend\models\Report $bigDiscount */
/** @var backend\models\Report $bigDelivery */
/** @var backend\models\Report $bigPlatform */
/** @var backend\models\Report $smallAllSum */
/** @var backend\models\Report $smallSum */
/** @var backend\models\Report $smallIncomingPriceSum */
/** @var backend\models\Report $smallDiscount */
/** @var backend\models\Report $smallDelivery */
/** @var backend\models\Report $smallPlatform */
/** @var backend\models\Report $periodStart */
/** @var backend\models\Report $periodEnd */
/** @var backend\models\Report $bigAllQty */
/** @var backend\models\Report $bigAllReturnQty */
/** @var backend\models\Report $bigQty */
/** @var backend\models\Report $smallAllQty */
/** @var backend\models\Report $smallAllReturnQty */
/** @var backend\models\Report $smallQty */
/** @var backend\models\Report $bigAllDelivery */
/** @var backend\models\Report $smallAllDelivery */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Reports Period');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$bigProfit = $bigSum
    - $bigIncomingPriceSum
    - $bigDiscount
    - $bigDelivery
    - $bigNovaPaySum
    - $bigPlatform;

$smallProfit = $smallSum
    - $smallIncomingPriceSum
    - $smallDiscount
    - $smallDelivery
    - $smallNovaPaySum
    - $smallPlatform;

$commonParams =
    [
        'action' => 'period-report',
        'periodStart' => $periodStart,
        'periodEnd' => $periodEnd
    ];
?>
<div id="top" class="sa-app__body">
    <div class="sa-invoice">
        <div class="py-5">
            <div class="row g-4 align-items-center">
                <?= $this->render('@backend/views/_partials/breadcrumbs'); ?>
                <div class="col-auto d-flex">
                    <?= Html::a(Yii::t('app', 'Звіт по Prom'), Url::to(['report/prom-report']), ['class' => 'btn btn-prom me-3']) ?>
                    <?= Html::a(Yii::t('app', 'Звіт по Рекламі'), Url::to(['report/advertising-report']), ['class' => 'btn btn-success me-3']) ?>
                    <?= Html::a(Yii::t('app', 'Таблиця'), Url::to(['index']), ['class' => 'btn btn-primary me-3']) ?>
                </div>
            </div>
        </div>
        <div class="sa-invoice__card">
            <div class="sa-invoice__header">
                <div class="sa-invoice__meta">
                    <div class="sa-invoice__title title-report mb-5">Звіт за Період</div>
                    <div class="sa-invoice__meta-items">
                        <?= $this->render('/_partials/report/input-date', $commonParams); ?>
                    </div>
                </div>
                <div class="sa-invoice__logo">
                    <?= $this->render('/_partials/report/invoice-logo'); ?>
                </div>
            </div>
            <div class="sa-invoice__sides">
                <div class="sa-invoice__table-container">
                    <div class="row" style="--bs-gutter-x: 0rem; padding-top: 5px">
                        <div class="col-auto d-flex">
                            <h4> Всі замовлення за період:</h4>
                            <?= Html::a(Yii::t('app', '<i class="far fa-file-excel"></i> Excel Всі'), Url::to(['report-export-to-excel']), ['class' => 'btn btn-outline-success', 'style' => 'margin-left: 20px;']) ?>
                            <?= Html::a(Yii::t('app', '<i class="far fa-file-excel"></i> Excel Фермер'), Url::to(['report-export-to-excel', 'package' => 'BIG']), ['class' => 'btn btn-outline-info', 'style' => 'margin-left: 20px;']) ?>
                            <?= Html::a(Yii::t('app', '<i class="far fa-file-excel"></i> Excel Дрібна'), Url::to(['report-export-to-excel', 'package' => 'SMALL']), ['class' => 'btn btn-outline-primary', 'style' => 'margin-left: 20px;']) ?>
                        </div>
                    </div>
                    <br>
                    <table class="sa-invoice__table">
                        <thead class="sa-invoice__table-head">
                        <tr>
                            <th class="sa-invoice__table-column--type--product">Відділ / Пакування</th>
                            <th class="sa-invoice__table-column--type--product"></th>
                            <th class="sa-invoice__table-column--type--quantity">Замов.</th>
                            <th class="sa-invoice__table-column--type--quantity">Повер.</th>
                            <th class="sa-invoice__table-column--type--price">Сума</th>
                        </tr>
                        </thead>
                        <tbody class="sa-invoice__table-body">
                        <tr>
                            <td class="sa-invoice__table-column--type--product">Фермерський Відділ</td>
                            <td class="sa-invoice__table-column--type--product"></td>
                            <td class="sa-invoice__table-column--type--quantity"><?= $bigAllQty ?></td>
                            <td class="sa-invoice__table-column--type--quantity"><?= $bigAllReturnQty ?></td>
                            <td class="sa-invoice__table-column--type--price"><?= Yii::$app->formatter->asDecimal($bigAllSum, 2) ?>
                                <span class="sa-price__symbol"></span></td>
                        </tr>
                        <tr>
                            <td class="sa-invoice__table-column--type--product">Дрібна фасовка</td>
                            <td class="sa-invoice__table-column--type--product"></td>
                            <td class="sa-invoice__table-column--type--quantity"><?= $smallAllQty ?></td>
                            <td class="sa-invoice__table-column--type--quantity"><?= $smallAllReturnQty ?></td>
                            <td class="sa-invoice__table-column--type--price"><?= Yii::$app->formatter->asDecimal($smallAllSum, 2) ?>
                                <span class="sa-price__symbol"></span></td>
                        </tr>
                        </tbody>
                        <tbody class="sa-invoice__table-totals">
                        <tr>
                            <th class="sa-invoice__table-column--type--header" colspan="3">Кількість замовлень:</th>
                            <td class="sa-invoice__table-column--type--total"><?= ($bigAllQty + $smallAllQty) - ($smallAllReturnQty + $bigAllReturnQty) ?></td>
                        </tr>
                        <tr>
                            <th class="sa-invoice__table-column--type--header" colspan="3">Доставка:</th>
                            <td class="sa-invoice__table-column--type--total text-danger"><span
                                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigAllDelivery + $smallAllDelivery, 2) ?>
                                <span
                                        class="sa-price__symbol"> ₴</span></td>
                        </tr>
                        <tr>
                            <th class="sa-invoice__table-column--type--header" colspan="3">Сума Продажів:</th>
                            <td class="sa-invoice__table-column--type--total"
                                style="font-weight: bold"><?= Yii::$app->formatter->asDecimal(($bigAllSum + $smallAllSum) - ($bigAllDelivery + $smallAllDelivery), 2) ?>
                                <span
                                        class="sa-price__symbol"> ₴</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= $this->render('/report/period/basic-table-period', [
                'bigQty' => $bigQty,
                'bigSum' => $bigSum,
                'bigIncomingPriceSum' => $bigIncomingPriceSum,
                'bigDiscount' => $bigDiscount,
                'bigDelivery' => $bigDelivery,
                'bigPlatform' => $bigPlatform,
                'bigProfit' => $bigProfit,
                'smallQty' => $smallQty,
                'smallSum' => $smallSum,
                'smallIncomingPriceSum' => $smallIncomingPriceSum,
                'smallDiscount' => $smallDiscount,
                'smallDelivery' => $smallDelivery,
                'smallPlatform' => $smallPlatform,
                'smallProfit' => $smallProfit,
                'bigNovaPaySum' => $bigNovaPaySum,
                'smallNovaPaySum' => $smallNovaPaySum,
            ]); ?>
            <div class="sa-invoice__disclaimer">
                <p>Цей варіант розрахунку називається коефіцієнт націнки (markup coefficient)
                    або коефіцієнт рентабельності продажів. Він показує, у скільки разів ціна продажу
                    перевищує собівартість.</p>
                <p>Формула:</p>

                <math xmlns="http://www.w3.org/1998/Math/MathML">
                    <mrow>
                        <mi>Коефіцієнт націнки</mi>
                        <mo>=</mo>
                        <mo>(</mo>
                        <mfrac>
                            <mi>Дохід</mi>
                            <mi>Собівартість</mi>
                        </mfrac>
                        <mo>-</mo>
                        <mn>1</mn>
                        <mo>)</mo>
                        <mo>×</mo>
                        <mn>100</mn>
                        <mo>%</mo>
                    </mrow>
                </math>
            </div>

            <div class="sa-invoice__disclaimer">
                <math xmlns="http://www.w3.org/1998/Math/MathML">
                    <mrow>
                        <mi>Маржинальність</mi>
                        <mo>=</mo>
                        <mfrac>
                            <mrow>
                                <mo>(</mo>
                                <mi>Дохід</mi>
                                <mo>-</mo>
                                <mi>Собівартість</mi>
                                <mo>)</mo>
                            </mrow>
                            <mi>Дохід</mi>
                        </mfrac>
                        <mo>×</mo>
                        <mn>100</mn>
                        <mo>%</mo>
                    </mrow>
                </math>
            </div>
        </div>
    </div>
</div>
<style>
    .title-report {
        padding: 0 10px;
        border-radius: 1000px;
        position: relative;
        background: rgba(189, 187, 193, 0.64);
        color: #1f2121;
        font-weight: 700;
    }
</style>
<script>
    document.getElementById('period-report-form').addEventListener('submit', function (e) {
        const button = this.querySelector('.btn-warning');

        // Установить состояние загрузки
        button.setAttribute('disabled', true);
        button.classList.add('btn-sa-loading');
    });
</script>
