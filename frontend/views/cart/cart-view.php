<?php

use common\models\Settings;
use common\models\shop\ActivePages;
use common\models\shop\MinimumOrderAmount;
use yii\helpers\Url;

$minimumOrderAmount = MinimumOrderAmount::find()->select('amount')->one();
ActivePages::setActiveUser();

if ($total_summ === 0) {
    $h = 'Ваш кошик порожній';
} else {
    $h = 'Ваш кошик';
}

$urlUpdate = Yii::$app->urlManager->createUrl(['cart/update']);
$urlQty = Yii::$app->urlManager->createUrl(['cart/qty-cart']);
$urlRemove = Yii::$app->urlManager->createUrl(['cart/remove']);

?>
<div class="cart-view">
    <button class="cart-view__close quickview__close" type="button">
        <svg width="20px" height="20px">
            <use xlink:href="/images/sprite.svg#cross-20"></use>
        </svg>
    </button>
    <div class="product product--layout--cart-view" data-layout="quickview">
        <div class="site__body">
            <div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__title">
                        <h1 style="font-size: 28px"> <?=Yii::t('app',$h) ?> </h1>
                    </div>
                </div>
            </div>
            <div class="cart block">
                <div class="container">
                    <table class="cart__table cart-table">
                        <thead class="cart-table__head">
                        <tr class="cart-table__row">
                            <th class="cart-table__column cart-table__column--image"></th>
                            <th class="cart-table__column cart-table__column--product"></th>
                            <th class="cart-table__column cart-table__column--price"><?=Yii::t('app','Ціна')?></th>
                            <th class="cart-table__column cart-table__column--quantity"><?=Yii::t('app','К-ть')?></th>
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
                                        <h5 class="card-title" style="color: red"><?=Yii::t('app','Замовлення від')?> <?= $minimumOrderAmount->amount ?>
                                            ₴</h5>
                                    <?php } ?>
                                    <table class="cart__totals">
                                        <tfoot class="cart__totals-footer">
                                        <tr>
                                            <th><?=Yii::t('app','Загальна сума')?></th>
                                            <td><?= Yii::$app->formatter->asCurrency($total_summ) ?></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <?php if ($total_summ != 0) { ?>
                                        <?php if ($total_summ < $minimumOrderAmount->amount) { ?>
                                            <a class="btn btn-primary btn-lg btn-block disabled cart__checkout-button"
                                               style="font-size: 16px"
                                               href="<?= Url::to(['order/checkout']) ?>"><?=Yii::t('app','Оформити замовлення')?></a>
                                        <?php } else { ?>
                                            <a class="btn btn-primary btn-lg btn-block cart__checkout-button"
                                               style="font-size: 16px"
                                               href="<?= Url::to(['order/checkout']) ?>"><?=Yii::t('app','Оформити замовлення')?></a>
                                        <?php } ?>
                                    <?php } ?>
                                    <a class="btn btn-warning btn-lg btn-block cart__checkout-button"
                                       style="font-size: 16px"
                                       href="<?= $_SERVER['HTTP_REFERER'] ?>"><?=Yii::t('app','Дивитись товари')?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function validateAndUpdateQty(input, prodId, urlUpdate, urlQty) {
        var qty = input.value.trim();  // Удаляем пробелы в начале и конце строки

        // Если поле пустое или значение не является числом, не обновляем количество
        if (qty === '' || isNaN(qty)) {
            return;
        }

        qty = parseInt(qty, 10);

        // Проверяем минимальное значение
        if (qty < input.min) {
            qty = input.min;
        }
        if (qty > input.max) {
            qty = input.max;
        }

        updateQty(prodId, qty, urlUpdate, urlQty);

        // Обновляем количество только если фокус потерян или пользователь завершил ввод (Enter)
        input.addEventListener('blur', function () {
            updateQty(prodId, qty, urlUpdate, urlQty);
        });

        // Если пользователь нажимает Enter, обновляем количество
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                input.blur(); // Снимем фокус, чтобы триггерить обновление через blur
            }
        });
    }

    function updateQty(prodId, qty, urlUpdate, urlQty) {
        if (qty !== 0) {
            setTimeout(function () {
                $.ajax({
                    url: urlUpdate,
                    data: {
                        id: prodId,
                        qty: qty
                    },
                    success: function (data) {
                        updateCartQty(urlQty);
                        $('.cart').html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Ошибка обновления количества товара:', textStatus, errorThrown);
                    }
                });
            }, 100);
        }
    }

    function removeProduct(id, urlRemove, urlQty) {
        $.ajax({
            url: urlRemove,
            data: {
                id: id,
            },
            success: function (data) {
                updateCartQty(urlQty);
                $('.cart').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Ошибка удаления товара из корзины:', textStatus, errorThrown);
            }
        });
    }

    function updateCartQty(urlQty) {
        $.ajax({
            url: urlQty,
            type: 'GET',
            success: function (qty) {
                $('#desc-qty-cart').html(qty.qty_cart);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Ошибка обновления количества товаров в корзине:', textStatus, errorThrown);
            }
        });
    }
</script>