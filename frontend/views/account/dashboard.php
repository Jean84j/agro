<?php

use yii\helpers\Url;

?>
<div class="dashboard">
    <div class="dashboard__profile card profile-card">
        <div class="card-body profile-card__body">
            <div class="profile-card__avatar">
                <img src="/images/avatars/no.jpg" alt="">
            </div>
            <div class="profile-card__name"><?= Yii::$app->user->identity->username ?></div>
            <div class="profile-card__email"><?= Yii::$app->user->identity->email ?></div>
            <div class="profile-card__edit">
                <a href="<?= Url::to(['account/view', 'card' => 'edit-profile']) ?>" class="btn btn-outline-info btn-sm">Edit Profile</a>
            </div>
        </div>
    </div>
    <div class="dashboard__address card address-card address-card--featured">
        <div class="address-card__badge">Default Address</div>

        <?php if ($lastOrder): ?>
        <div class="address-card__body">
            <div class="address-card__name"><?= $lastOrder->fio ?></div>
            <div class="address-card__row">
                <?= $lastOrder->area ?><br>
                <?= $lastOrder->city ?><br>
                <?= $lastOrder->warehouses ?>
            </div>
            <div class="address-card__row">
                <div class="address-card__row-title">Phone Number</div>
                <div class="address-card__row-content"><?= $lastOrder->phone ?></div>
            </div>
            <div class="address-card__row">
                <div class="address-card__row-title">Email Address</div>
                <div class="address-card__row-content"><?= Yii::$app->user->identity->email ?></div>
            </div>
            <div class="address-card__footer">
                <a href="account-edit-address.html">Edit Address</a>
            </div>
        </div>
        <?php endif; ?>

    </div>
    <div class="dashboard__orders card">

        <?php if ($orders): ?>

        <div class="card-header" style="background-color: gold">
            <h5>Останні замовлення</h5>
        </div>
        <div class="card-divider"></div>
        <div class="card-table">
            <div class="table-responsive-sm">
                <table>
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Date</th>
                        <th>Статус</th>
                        <th>Товари</th>
                        <th>Сума</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><a href="">#<?= $order->id ?></a></td>
                            <td><?= Yii::$app->formatter->asDatetime( $order->created_at) ?></td>
                            <td><?= $order->getExecutionStatus($order->id) ?></td>
                            <td><?= $order->getTotalQty($order->id) ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($order->getTotalSumm($order->id)) ?></td>
                        </tr>
                    <?php endforeach; ?>


                    </tbody>
                </table>
            </div>
        </div>

        <?php else: ?>
            <div class="card-header" style="background-color: gold">
                <h5>Ще немає замовлень </h5>
            </div>
        <?php endif; ?>

    </div>
</div>
