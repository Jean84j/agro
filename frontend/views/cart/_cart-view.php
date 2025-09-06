<?php

use common\models\Settings;
use common\models\shop\ActivePages;
use common\models\shop\MinimumOrderAmount;
use yii\helpers\Url;

$minimumOrderAmount = MinimumOrderAmount::find()->select('amount')->one();
ActivePages::setActiveUser();

$urlUpdate = Yii::$app->urlManager->createUrl(['cart/update']);
$urlQty = Yii::$app->urlManager->createUrl(['cart/qty-cart']);
$urlRemove = Yii::$app->urlManager->createUrl(['cart/remove']);

?>
<div class="cart block">
    <div class="container">
        <table class="cart__table cart-table">
            <thead class="cart-table__head">
            <tr class="cart-table__row">
                <th class="cart-table__column cart-table__column--image"></th>
                <th class="cart-table__column cart-table__column--product"></th>
                <th class="cart-table__column cart-table__column--price"><?= Yii::t('app', 'Ціна') ?></th>
                <th class="cart-table__column cart-table__column--quantity"><?= Yii::t('app', 'К-ть') ?></th>
                <th class="cart-table__column cart-table__column--remove"></th>
            </tr>
            </thead>
            <tbody class="cart-table__body">
            <?php foreach ($orders as $order): ?>
                <tr class="cart-table__row">
                    <td class="cart-table__column cart-table__column--image">
                        <div class="product-image">
                            <a href="<?= Url::to(['product/view', 'slug' => $order->slug]) ?>"
                               class="product-image__body">
                                <img class="product-image__img"
                                     src="<?= $order->getImgOne($order->getId()) ?>"
                                     width="80" height="80"
                                     alt="<?= $order->name ?>">
                            </a>
                        </div>
                    </td>
                    <td class="cart-table__column cart-table__column--product">
                        <a href="<?= Url::to(['product/view', 'slug' => $order->slug]) ?>"
                           class="cart-table__product-name"><?= $order->name ?></a>
                    </td>
                    <?php if ($order->currency == 'UAH'): ?>
                        <td class="cart-table__column cart-table__column--price"
                            data-title="Ціна"><?= Yii::$app->formatter->asCurrency($order->price) ?></td>
                    <?php else: ?>
                        <td class="cart-table__column cart-table__column--price"
                            data-title="Ціна"><?= Yii::$app->formatter->asCurrency($order->price * Settings::currencyRate($order->currency)) ?></td>
                    <?php endif; ?>
                    <td class="cart-table__column cart-table__column--quantity" data-title="Кількість">
                        <div class="input-number">
                            <input class="form-control input-number__input update-numb" type="number"
                                   min="1" max="999"
                                   value="<?= $order->getQuantity() ?>"
                                   data-url-update="<?= $urlUpdate ?>"
                                   onchange="validateAndUpdateQty(this, <?= $order->getId() ?>, '<?= $urlUpdate ?>', '<?= $urlQty ?>')"
                                   onpaste="this.onchange()"
                                   onkeyup="this.onchange()"
                                   oninput="this.onchange()">
                            <div class="input-number__add"
                                 onclick="updateQty(<?= $order->getId() ?>, <?= $order->getQuantity() + 1 ?>, '<?= $urlUpdate ?>', '<?= $urlQty ?>')"></div>
                            <div class="input-number__sub"
                                 onclick="updateQty(<?= $order->getId() ?>, <?= $order->getQuantity() - 1 ?>, '<?= $urlUpdate ?>', '<?= $urlQty ?>')"></div>
                        </div>
                    </td>
                    <td class="cart-table__column cart-table__column--remove"
                        onclick="removeProduct(<?= $order->id ?>, '<?= $urlRemove ?>', '<?= $urlQty ?>')">
                        <button type="button" class="btn btn-light btn-sm btn-svg-icon gtm-remove-cart">
                            <svg class="gtm-remove-cart" width="12px" height="12px">
                                <use xlink:href="/images/sprite.svg#cross-12"></use>
                            </svg>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row justify-content-end pt-5">
            <div class="col-12 col-md-9 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <?php if ($total_summ < $minimumOrderAmount->amount and $total_summ > 0) { ?>
                            <h5 class="card-title"
                                style="color: red"><?= Yii::t('app', 'Замовлення від') ?> <?= $minimumOrderAmount->amount ?>
                                ₴</h5>
                        <?php } ?>
                        <table class="cart__totals">
                            <tfoot class="cart__totals-footer">
                            <tr>
                                <th><?= Yii::t('app', 'Загальна сума') ?></th>
                                <td><?= Yii::$app->formatter->asCurrency($total_summ) ?></td>
                            </tr>
                            </tfoot>
                        </table>
                        <?php if ($total_summ != 0) { ?>
                            <?php if ($total_summ < $minimumOrderAmount->amount) { ?>
                                <a class="btn btn-primary btn-lg btn-block disabled cart__checkout-button"
                                   style="font-size: 16px"
                                   href="<?= Url::to(['order/checkout']) ?>"><?= Yii::t('app', 'Оформити замовлення') ?></a>
                            <?php } else { ?>
                                <a class="btn btn-primary btn-lg btn-block cart__checkout-button"
                                   style="font-size: 16px"
                                   href="<?= Url::to(['order/checkout']) ?>"><?= Yii::t('app', 'Оформити замовлення') ?></a>
                            <?php } ?>
                        <?php } ?>
                        <a class="btn btn-warning btn-lg btn-block cart__checkout-button"
                           style="font-size: 16px"
                           href="<?= $_SERVER['HTTP_REFERER'] ?>"><?= Yii::t('app', 'Дивитись товари') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

