<?php

use frontend\assets\AccountPageAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AccountPageAsset::register($this);

$h1 = 'Мій акаунт';
$breadcrumbItemActive = 'Мій акаунт';

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'h1' => $h1,
            'breadcrumbItemActive' => $breadcrumbItemActive,
        ]) ?>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3 d-flex">
                    <div class="account-nav flex-grow-1">
                        <h4 class="account-nav__title">Налаштування</h4>
                        <ul>
                            <li class="account-nav__item  <?= $card === 'dashboard' ? 'account-nav__item--active' : '' ?>">
                                <a href="<?= Url::to(['account/view', 'card' => 'dashboard']) ?>">Dashboard</a>
                            </li>
<!--                            <li class="account-nav__item --><?//= $card === 'edit-profile' ? 'account-nav__item--active' : '' ?><!--">-->
<!--                                <a href="--><?//= Url::to(['account/view', 'card' => 'edit-profile']) ?><!--">Edit Profile</a>-->
<!--                            </li>-->
<!--                            <li class="account-nav__item --><?//= $card === 'orders' ? 'account-nav__item--active' : '' ?><!--">-->
<!--                                <a href="--><?//= Url::to(['account/view', 'card' => 'orders']) ?><!--">Історія замовлень</a>-->
<!--                            </li>-->
<!--                            <li class="account-nav__item --><?//= $card === 'order-details' ? 'account-nav__item--active' : '' ?><!--">-->
<!--                                <a href="--><?//= Url::to(['account/view', 'card' => 'order-details']) ?><!--">Order Details</a>-->
<!--                            </li>-->
<!--                            <li class="account-nav__item --><?//= $card === 'addresses-list' ? 'account-nav__item--active' : '' ?><!--">-->
<!--                                <a href="--><?//= Url::to(['account/view', 'card' => 'addresses-list']) ?><!--">Addresses</a>-->
<!--                            </li>-->
<!--                            <li class="account-nav__item --><?//= $card === 'edit-address' ? 'account-nav__item--active' : '' ?><!--">-->
<!--                                <a href="--><?//= Url::to(['account/view', 'card' => 'edit-address']) ?><!--">Edit Address</a>-->
<!--                            </li>-->
<!--                            <li class="account-nav__item --><?//= $card === 'password' ? 'account-nav__item--active' : '' ?><!--">-->
<!--                                <a href="--><?//= Url::to(['account/view', 'card' => 'password']) ?><!--">Password</a>-->
<!--                            </li>-->
                            <li class="account-nav__item ">
                                <?= Html::a('Logout', ['site/logout'], [
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                    <?= $this->render($card, [
                        'orders' => $orders,
                        'lastOrder' => $lastOrder,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>