<?php

/** @var  $orders */
/** @var  $total_summ */
/** @var  $minimumOrderAmount */

?>
<div class="col-12 col-lg-6 col-xl-5 mt-4 mt-lg-0">
    <div class="card mb-0">
        <div class="card-body">
            <h3 class="card-title"><?= Yii::t('app', 'Ваше замовлення') ?></h3>
            <?= $this->render('_totals-products', [
                'orders' => $orders,
                'total_summ' => $total_summ,
                'minimumOrderAmount' => $minimumOrderAmount,
            ]) ?>
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
        document.addEventListener('change', function (event) {
            if (event.target && event.target.id === 'checkout-terms') {
                toggleSubmitButton();
            }
        });

        function toggleSubmitButton() {
            let checkbox = document.getElementById('checkout-terms');
            let submitButton = document.getElementById('orderTo');
            let checkboxContainer = document.getElementById('check-red');

            if (!checkbox || !submitButton || !checkboxContainer || checkbox.disabled) return;

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
    });
</script>