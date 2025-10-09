<?php

/** @var backend\models\Report $model */
/** @var backend\controllers\ReportController $bigAllSum */
/** @var backend\controllers\ReportController $bigSum */
/** @var backend\controllers\ReportController $bigIncomingPriceSum */
/** @var backend\controllers\ReportController $bigDiscount */
/** @var backend\controllers\ReportController $bigDelivery */
/** @var backend\controllers\ReportController $bigPlatform */
/** @var backend\controllers\ReportController $smallAllSum */
/** @var backend\controllers\ReportController $smallSum */
/** @var backend\controllers\ReportController $smallIncomingPriceSum */
/** @var backend\controllers\ReportController $smallDiscount */
/** @var backend\controllers\ReportController $smallDelivery */
/** @var backend\controllers\ReportController $smallPlatform */
/** @var backend\controllers\ReportController $periodStart */
/** @var backend\controllers\ReportController $periodEnd */
/** @var backend\controllers\ReportController $bigAllQty */
/** @var backend\controllers\ReportController $bigAllReturnQty */
/** @var backend\controllers\ReportController $bigQty */
/** @var backend\controllers\ReportController $smallAllQty */
/** @var backend\controllers\ReportController $smallAllReturnQty */
/** @var backend\controllers\ReportController $smallQty */
/** @var backend\controllers\ReportController $bigAllDelivery */
/** @var backend\controllers\ReportController $smallAllDelivery */
/** @var backend\controllers\ReportController $bigNovaPaySum */
/** @var backend\controllers\ReportController $smallNovaPaySum */

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

$tableBasicParams =
    [
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
    ];

$tableSecondParams =
    [
        'bigAllQty' => $bigAllQty,
        'bigAllReturnQty' => $bigAllReturnQty,
        'bigAllSum' => $bigAllSum,
        'smallAllQty' => $smallAllQty,
        'smallAllReturnQty' => $smallAllReturnQty,
        'smallAllSum' => $smallAllSum,
        'bigAllDelivery' => $bigAllDelivery,
        'smallAllDelivery' => $smallAllDelivery,
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
            <?= $this->render('/report/period/second-table-period', $tableSecondParams); ?>
            <?= $this->render('/report/period/basic-table-period', $tableBasicParams); ?>
            <?= $this->render('/report/period/disclaimer'); ?>
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
