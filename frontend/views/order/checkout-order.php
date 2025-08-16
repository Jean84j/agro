<?php

use yii\helpers\Url;

?>
<div class="col-12 col-lg-6 col-xl-5 mt-4 mt-lg-0">
    <div class="card mb-0">
        <div class="card-body">
            <h3 class="card-title"><?= Yii::t('app', 'Ваше замовлення') ?></h3>


            <table class="checkout__totals">
                <thead class="checkout__totals-header">
                <tr>
                    <th><?= Yii::t('app', 'Товар') ?></th>
                    <th><?= Yii::t('app', 'К-ть') ?></th>
                    <th><?= Yii::t('app', 'Всього') ?></th>
                </tr>
                </thead>
                <tbody class="checkout__totals-products">
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order->name ?></td>
                        <td><?= $order->quantity ?></td>
                        <td><?= Yii::$app->formatter->asCurrency($order->getPrice() * $order->quantity) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot class="checkout__totals-footer">
                <tr>
                    <th><?= Yii::t('app', 'Загальна сума') ?></th>
                    <td><?= Yii::$app->formatter->asCurrency($total_summ) ?></td>
                </tr>
                </tfoot>
            </table>


            <div class="checkout__agree form-group">
                <div class="form-check">
                                    <span id="check-red" class="form-check-input input-check">
                                        <span class="input-check__body shadow_element">
                                            <input class="input-check__input" type="checkbox"
                                                   id="checkout-terms" checked>
                                            <span class="input-check__box"></span>
                                            <svg class="input-check__icon" width="9px" height="7px">
                                                <use xlink:href="/images/sprite.svg#check-9x7"></use>
                                            </svg>
                                        </span>
                                    </span>
                    <label class="form-check-label"
                           for="checkout-terms"><?= Yii::t('app', 'Я прочитав ') ?>
                        <a style="font-weight: bold" target="_blank"
                           href="<?= Url::to(['/order/conditions']) ?>">
                            <?= Yii::t('app', ' умови повернення та обміну') ?> </a><span
                                style="color: red">*</span>
                        <?= Yii::t('app', ' та погоджуюся з інтернет-магазином') ?><span
                                style="font-weight: bold"> AgroPro</span>
                    </label>
                </div>
            </div>
            <?php if ($total_summ != 0) { ?>
                <button type="submit" id="orderTo" class="btn btn-primary btn-dec-lg btn-block shadow_element"
                        style="font-size: 16px"><?= Yii::t('app', 'Зробити замовлення') ?>
                </button>
            <?php } else { ?>
                <a class="btn btn-warning btn-dec-lg btn-block" style="font-size: 16px"
                   href="<?= Url::to(['/']) ?>"><?= Yii::t('app', 'Дивитись товари') ?></a>
            <?php } ?>
        </div>
    </div>
</div>
<style>
    .checkbox-error {
        border: 1px solid red;
    }
    .shadow_element {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2)
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let checkbox = document.getElementById('checkout-terms');
        let submitButton = document.getElementById('orderTo');
        let checkboxContainer = document.getElementById('check-red');

        function toggleSubmitButton() {
            if (checkbox.checked) {
                submitButton.disabled = false;
                submitButton.classList.remove('btn-secondary');
                submitButton.classList.add('btn-primary');
                checkboxContainer.classList.remove('checkbox-error');
            } else {
                submitButton.disabled = true;
                submitButton.classList.remove('btn-primary');
                submitButton.classList.add('btn-secondary');
                checkboxContainer.classList.add('checkbox-error');
            }
        }

        toggleSubmitButton();

        checkbox.addEventListener('change', toggleSubmitButton);
    });
</script>