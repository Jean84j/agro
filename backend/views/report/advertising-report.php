<?php

/** @var backend\models\Report $model */
/** @var backend\models\Report $budget */
/** @var backend\models\Report $bigSum */
/** @var backend\models\Report $bigIncomingPriceSum */
/** @var backend\models\Report $bigDiscount */
/** @var backend\models\Report $bigDelivery */
/** @var backend\models\Report $bigPlatform */
/** @var backend\models\Report $smallSum */
/** @var backend\models\Report $smallIncomingPriceSum */
/** @var backend\models\Report $smallDiscount */
/** @var backend\models\Report $smallDelivery */
/** @var backend\models\Report $smallPlatform */
/** @var backend\models\Report $periodStart */
/** @var backend\models\Report $periodEnd */
/** @var backend\models\Report $bigQty */

/** @var backend\models\Report $smallQty */

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Reports Advertising');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$bigProfit = $bigSum
    - $bigIncomingPriceSum
    - $bigDiscount
    - $bigDelivery
    - $bigPlatform;

$smallProfit = $smallSum
    - $smallIncomingPriceSum
    - $smallDiscount
    - $smallDelivery
    - $smallPlatform;

if ($bigQty + $smallQty == 0) {
    $clientPrice = $budget;
} else {
    $clientPrice = $budget / ($bigQty + $smallQty);
}

$commonParams =
    [
        'action' => 'advertising-report',
        'periodStart' => $periodStart,
        'periodEnd' => $periodEnd
    ];
if (isset($budget)) {
    $commonParams['budget'] = $budget;
}
?>
<div id="top" class="sa-app__body">
    <div class="sa-invoice">
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
                            ]);
                            ?>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto d-flex">
                    <?= Html::a(Yii::t('app', 'Звіт за Період'), Url::to(['report/period-report']), ['class' => 'btn btn-secondary me-3']) ?>
                    <?= Html::a(Yii::t('app', 'Звіт по Prom'), Url::to(['report/prom-report']), ['class' => 'btn btn-prom me-3']) ?>
                    <?= Html::a(Yii::t('app', 'Таблиця'), Url::to(['index']), ['class' => 'btn btn-primary me-3']) ?>
                </div>
            </div>
        </div>
        <div class="sa-invoice__card">
            <div class="sa-invoice__header">
                <div class="sa-invoice__meta">
                    <div class="sa-invoice__title title-report mb-5">Звіт по Рекламі</div>
                    <div class="sa-invoice__meta-items">
                        <?= $this->render('/_partials/report/input-date', $commonParams); ?>
                    </div>
                </div>
                <div class="sa-invoice__logo">
                    <?= $this->render('/_partials/report/invoice-logo'); ?>
                </div>
            </div>
            <div class="sa-invoice__table-container">
                <h4> Реклама замовлення за період: </h4>
                <br>
                <table class="sa-invoice__table">
                    <thead class="sa-invoice__table-head">
                    <tr>
                        <th class="sa-invoice__table-column--type--product">Відділ / Пакування</th>
                        <th class="sa-invoice__table-column--type--quantity">К-ть</th>
                        <th class="sa-invoice__table-column--type--price">Сума</th>
                        <th class="sa-invoice__table-column--type--price">Собі-ть</th>
                        <th class="sa-invoice__table-column--type--price">Знижки</th>
                        <th class="sa-invoice__table-column--type--price">Доставка</th>
                        <th class="sa-invoice__table-column--type--price">Платформи</th>
                        <th class="sa-invoice__table-column--type--total">Приб.</th>
                    </tr>
                    </thead>
                    <tbody class="sa-invoice__table-body">
                    <tr>
                        <td class="sa-invoice__table-column--type--product">Фермерський Відділ</td>

                        <td class="sa-invoice__table-column--type--quantity"><?= $bigQty ?></td>
                        <td class="sa-invoice__table-column--type--price"><?= Yii::$app->formatter->asDecimal($bigSum, 2) ?>
                            <span class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--price text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigIncomingPriceSum, 2) ?>
                            <span class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--price text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigDiscount, 2) ?>
                            <span
                                    class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--price text-danger"><span
                                    class="sa-price__symbol"></span>-<?= Yii::$app->formatter->asDecimal($bigDelivery, 2) ?>
                            <span
                                    class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--price text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigPlatform, 2) ?>
                            <span
                                    class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--total"><?= Yii::$app->formatter->asDecimal($bigProfit, 2) ?>
                            <span
                                    class="sa-price__symbol"></span></td>
                    </tr>
                    <tr>
                        <td class="sa-invoice__table-column--type--product">Дрібна фасовка</td>
                        <td class="sa-invoice__table-column--type--quantity"><?= $smallQty ?></td>
                        <td class="sa-invoice__table-column--type--price"><?= Yii::$app->formatter->asDecimal($smallSum, 2) ?>
                            <span class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--price text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($smallIncomingPriceSum, 2) ?>
                            <span class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--price text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($smallDiscount, 2) ?>
                            <span
                                    class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--price text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($smallDelivery, 2) ?>
                            <span
                                    class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--price text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($smallPlatform, 2) ?>
                            <span
                                    class="sa-price__symbol"></span></td>
                        <td class="sa-invoice__table-column--type--total"><?= Yii::$app->formatter->asDecimal($smallProfit, 2) ?>
                            <span
                                    class="sa-price__symbol"></span></td>
                    </tr>
                    </tbody>
                    <tbody class="sa-invoice__table-totals">
                    <tr>
                        <th class="sa-invoice__table-column--type--header" colspan="6">Кількість замовлень</th>
                        <td class="sa-invoice__table-column--type--total"><?= $bigQty + $smallQty ?></td>
                    </tr>
                    <tr>
                        <th class="sa-invoice__table-column--type--header" colspan="6">Сума Продажів</th>
                        <td class="sa-invoice__table-column--type--total"><?= Yii::$app->formatter->asDecimal($bigSum + $smallSum, 2) ?>
                            <span
                                    class="sa-price__symbol"> ₴</span></td>
                    </tr>
                    <tr>
                        <th class="sa-invoice__table-column--type--header" colspan="6">Ціна кліента</th>
                        <td class="sa-invoice__table-column--type--total"><?= Yii::$app->formatter->asDecimal($clientPrice, 2) ?>
                            <span
                                    class="sa-price__symbol"> ₴</span></td>
                    </tr>
                    <tr>
                        <th class="sa-invoice__table-column--type--header" colspan="6">Собівартість</th>
                        <td class="sa-invoice__table-column--type--total text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigIncomingPriceSum + $smallIncomingPriceSum, 2) ?>
                            <span
                                    class="sa-price__symbol"> ₴</span></td>
                    </tr>
                    <tr>
                        <th class="sa-invoice__table-column--type--header" colspan="6">Знижки</th>
                        <td class="sa-invoice__table-column--type--total text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigDiscount + $smallDiscount, 2) ?>
                            <span
                                    class="sa-price__symbol"> ₴</span></td>
                    </tr>
                    <tr>
                        <th class="sa-invoice__table-column--type--header" colspan="6">Доставка</th>
                        <td class="sa-invoice__table-column--type--total text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigDelivery + $smallDelivery, 2) ?>
                            <span
                                    class="sa-price__symbol"> ₴</span></td>
                    </tr>
                    <tr>
                        <th class="sa-invoice__table-column--type--header" colspan="6">Платформи</th>
                        <td class="sa-invoice__table-column--type--total text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigPlatform + $smallPlatform, 2) ?>
                            <span
                                    class="sa-price__symbol"> ₴</span></td>
                    </tr>
                    <tr>
                        <th class="sa-invoice__table-column--type--header" colspan="6">Бютжет</th>
                        <td class="sa-invoice__table-column--type--total text-danger"><span
                                    class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($budget, 2) ?>
                            <span
                                    class="sa-price__symbol"> ₴</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="sa-invoice__total">
                <div class="sa-invoice__total-title">Загальний Прибуток:</div>
                <div class="sa-invoice__total-value"><?= Yii::$app->formatter->asDecimal(($bigProfit + $smallProfit) - $budget, 2) ?>
                    <span
                            class="sa-price__symbol"> ₴</span></div>
            </div>
            <div>
                Агропроцвіт: <?= $agroprocvitCount ?>
                Facebook: <?= $faceBookCount ?>
                Instagram: <?= $instagramCount ?>
                Дзвінок: <?= $dzvinokCount ?>
            </div>
            <div class="sa-invoice__disclaimer">
                Information on technical characteristics, the delivery set, the country of manufacture and the
                appearance of the goods is for
                reference only and is based on the latest information available at the time of publication.
            </div>
        </div>
    </div>
</div>
<style>
    .title-report {
        padding: 0 10px;
        border-radius: 1000px;
        position: relative;
        background: rgba(4, 182, 48, 0.73);
        color: #eff2f4;
        font-weight: 700;
    }
</style>
