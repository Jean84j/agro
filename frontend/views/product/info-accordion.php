<?php

use yii\helpers\Url;

use common\models\shop\Brand;
use common\models\shop\Product;

/** @var Brand $img_brand */
/** @var Product $product */
/** @var Product $mobile */

?>
<div class="payment-methods">
    <ul class="payment-methods__list">
        <li class="payment-methods__item payment-methods__item--active">
            <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="" type="radio" checked="">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                <span class="delivery-methods__item-name">
                        <i style="font-size: 25px"
                           class="fas fa-qrcode">

                        </i>
                                            <span style="font-size:20px; margin:0 20px">
                                                <?= Yii::t('app', 'Артикул') ?>
                                            </span>
                    </span>
            </label>
            <div class="payment-methods__item-container" style="">
                <div class="payment-methods__item-description text-muted"
                     style="text-align: center;">
                    <b><?= $product->sku ?></b>
                </div>
            </div>
        </li>
        <li class="payment-methods__item">
            <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                <span class="delivery-methods__item-name"><i style="font-size: 25px"
                                                             class="fas fa-truck"></i>
                                            <span style="font-size:20px; margin:0 20px"><?= Yii::t('app', 'Доставка') ?></span></span>
            </label>
            <div class="payment-methods__item-container" style="">
                <div class="payment-methods__item-description text-muted">
                    <div style="display: flex; align-items: center;">
                        <svg width="24px" height="24px" style="margin-right: 5px;">
                            <use xlink:href="/images/sprite.svg#novaposhta"></use>
                        </svg>
                        <b><?= Yii::t('app', 'Нова Пошта') ?></b>
                    </div>
                    <ul>
                        <li>
                            <?= Yii::t('app', Yii::t('app', 'Від') . ' 80 ' . Yii::t('app', 'грн.')) ?>
                        </li>
                        <li>
                            <?= Yii::t('app', 'Тарифи') ?> <a
                                    href="https://novaposhta.ua/basic_tariffs"
                                    target="_bank"><?= Yii::t('app', 'перевізника') ?></a>
                        </li>
                    </ul>
                    <div style="display: flex; align-items: center;">
                        <svg width="24px" height="24px" style="margin-right: 5px;">
                            <use xlink:href="/images/sprite.svg#ukrposhta"></use>
                        </svg>
                        <b><?= Yii::t('app', 'Укрпошта') ?></b>
                    </div>
                    <ul>
                        <li>
                            <?= Yii::t('app', Yii::t('app', 'Від') . ' 40 ' . Yii::t('app', 'грн.')) ?>
                        </li>
                        <li>
                            <?= Yii::t('app', 'Тарифи') ?> <a
                                    href="https://www.ukrposhta.ua/ua/taryfy-ukrposhta-standart"
                                    target="_bank"><?= Yii::t('app', 'перевізника') ?></a>
                        </li>
                    </ul>
                    <div style="display: flex; align-items: center;">
                        <svg width="24px" height="24px" style="margin-right: 5px;">
                            <use xlink:href="/images/sprite.svg#delivery-48"
                                 style="fill: #47991f;"></use>
                        </svg>
                        <b><?= Yii::t('app', 'Самовивіз') ?></b>
                    </div>
                    <ul>
                        <li>
                            <?= Yii::t('app', 'Відвантаження з Полтави') ?>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="payment-methods__item">
            <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="beznal" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                <span class="payment-methods__item-name"><i style="font-size: 25px"
                                                            class="fas fa-credit-card"></i> <span
                            style="font-size:20px; margin:0 20px"><?= Yii::t('app', 'Оплата') ?></span></span>
            </label>
            <div class="payment-methods__item-container" style="">
                <div class="payment-methods__item-description text-muted">
                    <ul>
                        <li><?= Yii::t('app', 'Visa/Mastercard') ?></li>
                        <li><?= Yii::t('app', 'Оплатити готівкою') ?></li>
                        <li><?= Yii::t('app', 'Наложенний платіж') ?></li>
                        <li><?= Yii::t('app', 'Розрахунковий рахунок') ?></li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="payment-methods__item">
            <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="online" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                <span class="shield-methods__item-name"><i style="font-size: 25px"
                                                           class="fas fa-shield-alt"></i> <span
                            style="font-size:20px; margin:0 12px">
                                                    <?= Yii::t('app', 'Повернення') ?></span></span>
            </label>
            <div class="payment-methods__item-container" style="">
                <div class="payment-methods__item-description text-muted">
                    <ul>
                        <li>
                            <?= Yii::t('app', 'Умови повернення та') ?>
                            <a target="_blank" href="<?= Url::to(['order/conditions']) ?>">
                                <?= Yii::t('app', 'обміну') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
    <?php if (!$mobile): ?>
        <div>
            <?php if ($product->brand_id != null): ?>
                <a href="<?= Url::to(['brands/catalog', 'slug' => $img_brand->slug]) ?>">
                    <img src="/images/brand/<?= $img_brand->file ?>"
                         width="330" height="54"
                         alt="<?= $img_brand->name ?>"
                         loading="lazy"
                         style="width: 100%; margin-top: 10px;">
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>