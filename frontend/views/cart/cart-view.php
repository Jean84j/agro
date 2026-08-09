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

                const $target = data.qty > 0 ? $('.cart') : $('#cart-view-modal .modal-content');

                $target.fadeOut(200, function() {
                    $(this).html(data.html).fadeIn(200);
                });

                let buttons = $('.product-card__addtocart[data-product-id="' + id + '"]');
                buttons.html(
                    '<svg width="20px" height="20px" style="display: unset;">' +
                    '<use xlink:href="/images/sprite.svg#cart-20"></use>' +
                    '</svg> ' + buttons.first().data('defaultBtn')
                );

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