<?php

use Detection\MobileDetect;
use yii\helpers\Html;
use yii\helpers\Url;

$mt_5 = '';
?>
<div class="sa-entity-layout__sidebar">
    <?php if ($events): ?>
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                <h2 class="fs-exact-16 mb-0"><i class="fas fa-comment-dots"></i> Активні Нагадування</h2>
                <a href="#" class="fs-exact-14">Edit</a>
            </div>
            <div class="card-body pt-4 fs-exact-14">
                <?php foreach ($events as $event): ?>
                    <div class="mb-3 p-3 border rounded shadow-sm bg-light position-relative">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <strong class="me-3"><?= Yii::$app->formatter->asDate($event->date, 'php:d.m.Y') ?></strong>
                            <span><?= Html::encode($event->event) ?></span>
                        </div>
                        <?php if (!empty($event->comment)): ?>
                            <div class="mt-2 text-muted">
                                <i class="fas fa-comment-dots me-1"></i>
                                <?= Html::encode($event->comment) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Кнопка видалення -->
                        <?= Html::beginForm(['report-reminder/delete', 'id' => $event->id], 'post', [
                            'style' => 'position: absolute; top: 5px; right: 8px;',
                            'data-method' => 'post',
                        ]) ?>
                        <?= Html::submitButton('<i class="fas fa-trash-alt"></i>', [
                            'class' => 'btn btn-sm btn-outline-danger',
                            'title' => 'Видалити',
                        ]) ?>
                        <?= Html::endForm() ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php $mt_5 = 'mt-5'; endif; ?>
    <div class="card <?= $mt_5 ?>">
        <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
            <h2 class="fs-exact-16 mb-0"><i class="fas fa-users"></i> Замовник</h2>
            <a href="#" class="fs-exact-14">Edit</a>
        </div>
        <div class="card-body d-flex align-items-center pt-4">
            <div class="sa-symbol sa-symbol--shape--circle sa-symbol--size--lg">
                <img src="<?= Yii::$app->request->hostInfo . '/images/customer.png' ?>"
                     width="60" height="60" alt=""/>
            </div>
            <div class="ms-3 ps-2">
                <div class="fs-exact-14 fw-medium"><a
                            href="<?= Url::to(['update', 'id' => $model->id]) ?>"
                            class="text-reset"><?= $model->fio ?></a></div>
                <?php $countOrders = $model->getCountOrders($model->tel_number) ?>
                <?php if ($countOrders < 2) { ?>
                    <div class="fs-exact-13 text-muted">Це перше замовлення</div>
                <?php } else { ?>
                    <div class="fs-exact-13 text-muted">
                        Замовлень <?= $countOrders ?></div>
                <?php } ?>
            </div>
        </div>
        <?php if ($countOrders >= 2) { ?>
            <?php $statusOrders = $model->getStatusOrdersView($model->tel_number) ?>
            <?php foreach ($statusOrders as $order): ?>
                <div class="sa-order-meta">
                    <div class="sa-page-meta__body">
                        <div class="sa-page-meta__list">
                            <div class="sa-page-meta__item">
                                <?php if (!empty($order['date_order'])) : ?>
                                    <span class="text-success">
            <a href="<?= Url::to(['view', 'id' => $order['id']]) ?>" class="text-reset">
                <?= Yii::$app->formatter->asDate($order['date_order'], 'php:d-m-Y') ?>
            </a>
        </span>
                                <?php else : ?>
                                    <span class="text-danger">Відсутня</span>
                                <?php endif; ?>
                            </div>

                            <div class="sa-page-meta__item">
                                <?= $model->getExecutionStatus($order['order_status_id']) ?>
                            </div>
                            <div class="sa-page-meta__item">
                                <?= $model->getPayMentStatus($order['order_pay_ment_id']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php } ?>
        <br>
    </div>
    <div class="card mt-5">
        <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
            <h2 class="fs-exact-16 mb-0"><i class="fas fa-user-check"></i> Контактна
                Особа</h2>
            <?php
            $det = new MobileDetect();
            $device_mob = $det->isMobile();
            if ($device_mob) {
                $znak = '%2B';
            } else {
                $znak = '+';
            }
            $telNumber = $model->tel_number ?? '';
            $call = str_replace(array('(', ')', ' ', '+'), '', $telNumber);
            $viberSms = 'viber://chat?number=' . $znak . $call;
            $button3 = Html::a("<i class=\"fab fa-viber\"></i>", $viberSms, [
                'title' => 'Написать в Viber',
                'class' => 'pull-left detail-button',
                'style' => 'margin-right: 20px; font-size:22px; color:#7159e2;'
            ]);
            ?>
            <div class="sa-page-meta__item" style="text-align: end;">
                <?= $button3 ?>
            </div>
        </div>
        <div class="card-body pt-4 fs-exact-14">
            <div><a href="<?= Url::to(['update', 'id' => $model->id]) ?>"
                    class="text-reset"><?= $model->fio ?></a></div>
            <div class="mt-1"><a href="#">moore@example.com</a></div>
            <div class="text-muted mt-1"><?= $model->tel_number ?></div>
        </div>
    </div>
    <?php if (!empty($model->address)): ?>
        <div class="card mt-5">
            <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                <h2 class="fs-exact-16 mb-0"><i class="far fa-address-card"></i> Адреса
                    Доставки</h2>
                <a href="#" class="fs-exact-14">Edit</a>
            </div>
            <div class="card-body pt-4 fs-exact-14">
                <?= $model->address ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (!empty($model->ttn)): ?>
        <div class="card mt-5">
            <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                <h2 class="fs-exact-16 mb-0"><i class="fas fa-barcode"></i> Накладна ТТН
                </h2>
                <a href="#" class="fs-exact-14">Edit</a>
            </div>
            <div class="card-body pt-4 fs-exact-14">
                <?= $model->ttn ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (!empty($model->comments)): ?>
        <div class="card mt-5">
            <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                <h2 class="fs-exact-16 mb-0"><i class="fas fa-comment-dots"></i> Коментар
                </h2>
                <a href="#" class="fs-exact-14">Edit</a>
            </div>
            <div class="card-body pt-4 fs-exact-14">
                <?= $model->comments ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<style>
    .sa-order-meta {
        padding: 1px 7px;
        font-size: 0.875rem;
        line-height: 1.25rem;
        margin-bottom: 2px;
    }
</style>
