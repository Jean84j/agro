<?php

use yii\bootstrap5\Breadcrumbs;
use common\models\Settings;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Report $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

$cursDollar = Settings::currencyRate();

$sumItemOrder = $model->getTotalSumView($model->id);
$itemDiscount = $model->getItemsDiscount($model->id);
$incomingPriceSum = $model->getItemsIncomingPrice($model->id);
$itemPlatformPrice = $model->getItemsPlatformPrice($model->id);

$deliveryPrice = $model->price_delivery ?? 0;
$novaPay = $model->nova_pay ?? 0;

$sum = $model->getTotalSumm($model->id) - $novaPay;

if ($model->order_status_id == 'Повернення' || $model->order_pay_ment_id == 'Повернення') {
    $totalOrderPrice = '-' . ($itemPlatformPrice + $deliveryPrice + $novaPay);
} else {
    $totalOrderPrice = $sumItemOrder
        - $incomingPriceSum
        - $itemDiscount
        - $itemPlatformPrice
        - $deliveryPrice
        - $novaPay;
}

?>
<div class="sa-app sa-app--desktop-sidebar-shown sa-app--mobile-sidebar-hidden sa-app--toolbar-fixed">
    <div class="sa-app__content">
        <div id="top" class="sa-app__body">
            <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
                <div class="container container--max--xl" style="max-width: 1623px">
                    <div class="py-4">
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

                            </div>
                        </div>
                    </div>
                    <div class="sa-page-meta mb-5">
                        <div class="sa-page-meta__body">
                            <div class="sa-page-meta__list">
                                <div class="sa-page-meta__item"><h5 class="m-0">Замовлення
                                        # <?= $model->number_order ?></h5></div>
                                <div class="sa-page-meta__item" style="font-weight: bold; font-size: 18px">
                                        <span class="text-muted"
                                              style="font-size: 14px">Позицій: </span><?= $model->getCountItemsOrder($model->id) ?>
                                </div>
                                <div class="sa-page-meta__item" style="font-weight: bold; font-size: 18px">
                                        <span class="text-muted"
                                              style="font-size: 14px">Дата відп.: </span>
                                    <?= !empty($model->date_delivery) ? '<span class="text-success">' . Yii::$app->formatter->asDate($model->date_delivery, 'php:d-m-Y') . '</span>' : '<span class="text-danger">Відсутня</span>' ?>
                                </div>
                                <div class="sa-page-meta__item" style="font-weight: bold; font-size: 18px">
                                        <span class="text-muted"
                                              style="font-size: 14px">Сума: </span><?php if ($model->order_status_id === 'Повернення') { ?>
                                        <span style="font-weight: bold; color: red">
                                                <?= Yii::$app->formatter->asDecimal($sum, 2) ?></span>
                                    <?php } else { ?>
                                        <span style="font-weight: bold"><?= Yii::$app->formatter->asDecimal($sum, 2) ?></span>
                                    <?php } ?></div>
                                <div class="sa-page-meta__item d-flex align-items-center fs-6">
                                    <?= $model->getExecutionStatus($model->order_status_id) ?>
                                </div>
                                <div class="sa-page-meta__item d-flex align-items-center fs-6">
                                    <?= $model->getPayMentStatus($model->order_pay_ment_id) ?>
                                </div>
                                <div class="sa-page-meta__item d-flex align-items-center fs-6"
                                     style="width: 20px; height: 20px">
                                    <?= $model->getDeliveryLogo($model->delivery_service) ?>
                                </div>
                                <div class="sa-page-meta__item d-flex align-items-center fs-6">
                                    <div class="col-auto d-flex">
                                        <?php echo Html::a('Редагувати', Url::to(['update', 'id' => $model->id]), [
                                            'class' => "btn btn-primary btn-sm",
                                        ]) ?>
                                    </div>
                                </div>
                                <div class="sa-page-meta__item d-flex align-items-center fs-6">
                                    <div class="col-auto d-flex">
                                        <?= Html::a('<i class="fas fa-bell"></i>', '#', [
                                            'class' => 'btn btn-outline-danger btn-sm',
                                            'data-bs-toggle' => 'modal',
                                            'data-bs-target' => '#addReportReminderModal',
                                            'title' => 'Додати нагадування', // всплывающая подсказка
                                        ]) ?>
                                    </div>

                                </div>
                                <div class="sa-page-meta__item"></div>
                            </div>
                        </div>
                    </div>
                    <div class="sa-entity-layout" data-sa-container-query='{"920":"sa-entity-layout--size--md"}'>
                        <div class="sa-entity-layout__body">
                            <div class="sa-entity-layout__main">
                                <div class="card">
                                    <div class="card-body px-5 py-4 d-flex align-items-center justify-content-between">
                                        <h2 class="mb-0 fs-exact-18 me-4"><i class="fas fa-seedling"></i> Товари
                                        </h2>
                                        <div class="text-muted fs-exact-14"><a href="#" data-bs-toggle="modal"
                                                                               data-bs-target="#addReportItemModal"><i
                                                        class="fas fa-plus"></i></a></div>
                                    </div>
                                    <?= $this->render('modal-add-product', ['id' => $model->id, 'curs' => $cursDollar]) ?>
                                    <?= $this->render('modal-add-reminder', ['id' => $model->id]) ?>
                                    <?php if ($model->reportItems): ?>
                                        <div class="table-responsive">
                                            <table class="sa-table">
                                                <thead style="background-color: #4ce7354f">
                                                <tr>
                                                    <th class="text-left">№</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="text-center">К-ть</th>
                                                    <th class="text-center">Ціна</th>
                                                    <th class="text-center">Сума</th>
                                                    <th class="text-center">Вхід</th>
                                                    <th class="text-center">Знижка</th>
                                                    <th class="text-center">Площадка</th>
                                                    <th class="text-center">Курс</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $i = 1;
                                                foreach ($model->reportItems as $reportItem): ?>
                                                    <tr>
                                                        <td class="text-left"><?= $i ?></td>
                                                        <td class="min-w-20x">
                                                            <div class="d-flex align-items-center">
                                                                <img src="<?= Yii::$app->request->hostInfo . '/images/product.png' ?>"
                                                                     width="40" height="40" alt=""/>
                                                                <span class="text-reset"><?= $reportItem->product_name ?></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-center"><?= $model->getPackageForView($reportItem->package) ?></td>
                                                        <td class="text-center"><?= $reportItem->quantity ?></td>
                                                        <td class="text-center">
                                                            <div class="sa-price">
                                                                <span class="sa-price__symbol"><?= Yii::$app->formatter->asDecimal($reportItem->price, 2) ?></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-center" style="background-color: #e4e7e4">
                                                            <div class="sa-price">
                                                                <?= Yii::$app->formatter->asDecimal($reportItem->price * $reportItem->quantity, 2) ?>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="sa-price">
                                                                <span class="sa-price__symbol"><?= Yii::$app->formatter->asDecimal($reportItem->entry_price, 2) ?></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-center text-danger">
                                                            <div class="sa-price">
                                                                <span class="sa-price__symbol">-</span>
                                                                <span class="sa-price__symbol">
                                                                        <?php if ($reportItem->discount) {
                                                                            $itemDiscountPrice = $reportItem->discount;
                                                                        } else {
                                                                            $itemDiscountPrice = 0;
                                                                        } ?>
                                                                        <?= Yii::$app->formatter->asDecimal($itemDiscountPrice, 2) ?>
                                                                    </span>
                                                            </div>
                                                        </td>
                                                        <td class="text-center text-danger">
                                                            <div class="sa-price">
                                                                <span class="sa-price__symbol">-</span>
                                                                <span class="sa-price__symbol">
                                                                        <?php if ($reportItem->platform_price) {
                                                                            $platformPrice = $reportItem->platform_price;
                                                                        } else {
                                                                            $platformPrice = 0;
                                                                        } ?>
                                                                        <?= Yii::$app->formatter->asDecimal($platformPrice, 2) ?>
                                                                    </span>
                                                            </div>
                                                        </td>
                                                        <td class="text-center"><?= Yii::$app->formatter->asDecimal($reportItem->kurs, 2) ?></td>
                                                        <td class="text-end">
                                                            <div class="text-muted fs-exact-14">
                                                                <a href="#" data-bs-toggle="modal"
                                                                   data-bs-target="#editReportItemModal<?= $reportItem->id ?>">
                                                                    <i class="fas fa-pen"></i>
                                                                </a>
                                                            </div>
                                                            <div class="text-muted fs-exact-14">
                                                                <a href="<?= Url::to(['report/delete-report-item', 'id' => $reportItem->id]) ?>"
                                                                   class="text-danger"
                                                                   onclick="return confirm('Вы уверены, что хотите удалить этот товар из заказа?')">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?= $this->render('modal-update-product', ['reportItem' => $reportItem]) ?>
                                                    <?php $i++; endforeach; ?>
                                                </tbody>
                                                <tbody class="sa-table__group">
                                                <tr>
                                                    <td colspan="3">Сума
                                                        <div class="text-muted fs-exact-13">сума всіх товарів</div>
                                                    </td>
                                                    <td class="text-end text-nowrap">
                                                        <div class="sa-price"
                                                             style="font-weight: bold; font-size: 20px">
                                                            <?= Yii::$app->formatter->asDecimal($sumItemOrder, 2) ?>
                                                            <span class="sa-price__symbol"> ₴</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php if ($incomingPriceSum != 0): ?>
                                                    <tr>
                                                        <td colspan="3">Сума Входу
                                                            <div class="text-muted fs-exact-13">сума всіх вхідних
                                                                цін
                                                            </div>
                                                        </td>
                                                        <td class="text-end text-nowrap">
                                                            <div class="sa-price">
                                                                <?= Yii::$app->formatter->asDecimal($incomingPriceSum, 2) ?>
                                                                <span class="sa-price__symbol"> ₴</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if ($itemDiscount != 0): ?>
                                                    <tr>
                                                        <td colspan="3">Знижка
                                                            <div class="text-muted fs-exact-13">знижка всіх товарів
                                                            </div>
                                                        </td>
                                                        <td class="text-end text-nowrap text-danger">
                                                            <div class="sa-price">
                                                                <span class="sa-price__symbol">-</span>
                                                                <?= Yii::$app->formatter->asDecimal($itemDiscount, 2) ?>
                                                                <span class="sa-price__symbol"> ₴</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if ($novaPay != 0): ?>
                                                    <tr>
                                                        <td colspan="3">NovaPay
                                                            <div class="text-muted fs-exact-13">сума комісії NovaPay
                                                            </div>
                                                        </td>
                                                        <td class="text-end text-nowrap text-danger">
                                                            <div class="sa-price">
                                                                <span class="sa-price__symbol">-</span>
                                                                <?= Yii::$app->formatter->asDecimal($novaPay, 2) ?>
                                                                <span class="sa-price__symbol"> ₴</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if ($itemPlatformPrice != 0): ?>
                                                    <tr>
                                                        <td colspan="3">Площадка
                                                            <div class="text-muted fs-exact-13">зписання коштів з
                                                                площадок
                                                            </div>
                                                        </td>
                                                        <td class="text-end text-nowrap text-danger">
                                                            <div class="sa-price">
                                                                <span class="sa-price__symbol">-</span>
                                                                <?= Yii::$app->formatter->asDecimal($itemPlatformPrice, 2) ?>
                                                                <span class="sa-price__symbol"> ₴</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if ($deliveryPrice != 0): ?>
                                                    <tr>
                                                        <td colspan="3">
                                                            Доставка
                                                            <div class="text-muted fs-exact-13">витрати на доставку
                                                            </div>
                                                        </td>
                                                        <td class="text-end text-nowrap text-danger">
                                                            <div class="sa-price">
                                                                <span class="sa-price__symbol">-</span>
                                                                <?= Yii::$app->formatter->asDecimal($deliveryPrice, 2) ?>
                                                                <span class="sa-price__symbol"> ₴</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                </tbody>
                                                <tbody>
                                                <tr>
                                                    <td colspan="3"><i class="fas fa-money-bill-wave"></i> Прибуток
                                                        <div class="text-muted fs-exact-13">загальна сума з
                                                            урахуванням витрат
                                                    </td>
                                                    <td class="text-end text-nowrap <?= $totalOrderPrice < 0 ? 'text-danger' : 'text-success' ?>">
                                                        <div class="sa-price" style="font-weight: bold">
                                                            <?= Yii::$app->formatter->asDecimal($totalOrderPrice, 2) ?>
                                                            <span class="sa-price__symbol"> ₴</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?= $this->render('sidebar', ['model' => $model, 'events' => $events]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- sa-app__toasts -->
    <div class="sa-app__toasts toast-container bottom-0 end-0"></div>
    <!-- sa-app__toasts / end -->
</div>
