<?php

use common\models\ActivePages;

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
    var qtyTimeout = qtyTimeout || null;

    function updateQty(prodId, qty, urlUpdate) {
        if (qty <= 0) return;

        clearTimeout(qtyTimeout);

        qtyTimeout = setTimeout(function () {
            $.ajax({
                url: urlUpdate,
                type: 'POST',
                data: { id: prodId, qty: qty },
                success: function (data) {

                    $('#desc-qty-cart').html(data.qty);

                    let orders = $('#orders-total');
                    if (orders.length) {
                        orders.replaceWith(data.order);
                    }

                    $('.cart').html(data.html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Ошибка обновления количества товара:', textStatus, errorThrown);
                }
            });
        }, 300);
    }

    function validateAndUpdateQty(input, prodId, urlUpdate) {
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

        updateQty(prodId, qty, urlUpdate);
    }

    function removeProduct(id, urlRemove) {
        let orders = $('#orders-total');
        $.ajax({
            url: urlRemove,
            type: 'POST',
            data: { id: id },
            success: function (data) {

                $('#desc-qty-cart').html(data.qty);


                if (orders.length) {
                    orders.replaceWith(data.order);
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

</script>