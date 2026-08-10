<?php

use common\models\shop\ActivePages;

/** @var  $orders */
/** @var  $urls */
/** @var  $total_summ */
/** @var  $minimumOrderAmount */

ActivePages::setActiveUser();

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
                        <h1 style="font-size: 28px"> <?= Yii::t('app', 'Ваш кошик') ?> </h1>
                    </div>
                </div>
            </div>
            <?= $this->render('_cart-view', [
                'orders' => $orders,
                'urls' => $urls,
                'total_summ' => $total_summ,
                'minimumOrderAmount' => $minimumOrderAmount,
            ]) ?>
        </div>
    </div>
</div>
<script>
    let qtyTimeout = null;

    // Функция отправки AJAX
    function updateQty(prodId, qty, urlUpdate, urlQty, urlOrderQty) {
        if (qty <= 0) return;

        // Отменяем предыдущий таймер, если пользователь продолжает ввод
        clearTimeout(qtyTimeout);

        qtyTimeout = setTimeout(function () {
            $.ajax({
                url: urlUpdate,
                data: { id: prodId, qty: qty },
                success: function (data) {
                    updateCartQty(urlQty);

                    // Корректная проверка наличия элемента в DOM
                    if ($('#orders-total').length && urlOrderQty) {
                        updateOrderQty(urlOrderQty);
                    }
                    $('.cart').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Ошибка обновления количества товара:', textStatus, errorThrown);
                }
            });
        }, 300); // 300ms задержка для предотвращения спама запросами
    }

    // Валидация и запуск обновления
    function validateAndUpdateQty(input, prodId, urlUpdate, urlQty, urlOrderQty) {
        var rawValue = input.value.trim();

        if (rawValue === '' || isNaN(rawValue)) return;

        var qty = parseInt(rawValue, 10);
        var min = parseInt(input.min, 10) || 1;
        var max = parseInt(input.max, 10) || Infinity;

        if (qty < min) qty = min;
        if (qty > max) qty = max;

        // Обновляем значение в самом инпуте, если оно вышло за границы
        if (input.value != qty) {
            input.value = qty;
        }

        updateQty(prodId, qty, urlUpdate, urlQty, urlOrderQty);
    }

    function removeProduct(id, urlRemove, urlQty, urlOrderQty) {
        $.ajax({
            url: urlRemove,
            data: { id: id },
            success: function (data) {
                updateCartQty(urlQty);

                if ($('#orders-total').length && urlOrderQty) {
                    updateOrderQty(urlOrderQty);
                }

                const $target = data.qty > 0 ? $('.cart') : $('#cart-view-modal .modal-content');

                $target.fadeOut(200, function () {
                    $(this).html(data.html).fadeIn(200);
                });

                let buttons = $('.product-card__addtocart[data-product-id="' + id + '"]');
                if (buttons.length) {
                    buttons.html(
                        '<svg width="20px" height="20px" style="display: unset;">' +
                        '<use xlink:href="/images/sprite.svg#cart-20"></use>' +
                        '</svg> ' + buttons.first().data('defaultBtn')
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Ошибка удаления товара из корзины:', textStatus, errorThrown);
            }
        });
    }

    function updateCartQty(urlQty) {
        if (!urlQty) return;
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

    function updateOrderQty(urlOrderQty) {
        if (!urlOrderQty) return;
        $.ajax({
            url: urlOrderQty,
            type: 'GET',
            success: function (data) {
                $('#orders-total').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Ошибка обновления в Orders:', textStatus, errorThrown);
            }
        });
    }
</script>