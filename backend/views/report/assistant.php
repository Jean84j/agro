<?php

use backend\models\Report;

$this->title = Yii::t('app', 'Асистент');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <?= $this->render('@backend/views/_partials/breadcrumbs'); ?>
                    <div class="col-auto d-flex">

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="p-4">
                    <input
                        type="text"
                        placeholder="<?=Yii::t('app', 'Start typing to search for statuses')?>"
                        class="form-control form-control--search mx-auto"
                        id="table-search"
                    />
                </div>
                <div class="sa-divider"></div>
                <table class="sa-datatables-init" data-order='[[ 1, "asc" ]]' data-sa-search-input="#table-search">
                    <thead>
                    <tr style="background-color: #ff9900c9">
                        <th class="min-w-15x"><?=Yii::t('app', 'Problem')?></th>
                        <th class="min-w-15x"><?=Yii::t('app', 'Orders')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $statusDelivery = Report::StatusDeliveryNotSelected()  ?>
                    <?php if ($statusDelivery): ?>
                        <tr>
                            <td class="problem-color">Статус Доставки не вказано</td>
                            <td>
                                <?= $statusDelivery ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $statusPayment = Report::StatusPaymentNotSelected() ?>
                    <?php if ($statusPayment): ?>
                        <tr>
                            <td class="problem-color">Статус Оплати не вказано</td>
                            <td>
                                <?= $statusPayment ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $statusPayment = Report::IncomingPriceNotSelected() ?>
                    <?php if ($statusPayment): ?>
                        <tr>
                            <td class="problem-color">Ціна входу не вказана</td>
                            <td>
                                <?= $statusPayment ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $ttn = Report::TtnNot() ?>
                    <?php if ($ttn): ?>
                        <tr>
                            <td class="problem-color">Статус Доставляєть нема ТТН</td>
                            <td>
                                <?= $ttn ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $number = Report::NunberNot() ?>
                    <?php if ($number): ?>
                        <tr>
                            <td class="problem-color">Відсутній № замовлення</td>
                            <td>
                                <?= $number ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $dataPayment = Report::DatePaymentNot() ?>
                    <?php if ($dataPayment): ?>
                        <tr>
                            <td class="problem-color">Статус Оплачено нема дати</td>
                            <td>
                                <?= $dataPayment ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $typePayment = Report::TypePaymentNot() ?>
                    <?php if ($typePayment): ?>
                        <tr>
                            <td class="problem-color">Статус Оплачено нема Способу Оплати</td>
                            <td>
                                <?= $typePayment ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $ordersMount = Report::StatusUnpaidMonth() ?>
                    <?php if ($ordersMount): ?>
                        <tr>
                            <td class="problem-color">Статус Не оплачено більше місяця</td>
                            <td>
                                <?= $ordersMount ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php $ordersNovaPay = Report::NonNovaPay() ?>
                    <?php if ($ordersNovaPay): ?>
                        <tr>
                            <td class="problem-color">Комісія NovaPay не вказана</td>
                            <td>
                                <?= $ordersNovaPay ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .problem-color {
        background-color: #6ae78966;
    }
</style>
