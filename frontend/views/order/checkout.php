<?php

use common\models\shop\ActivePages;
use frontend\assets\OrderCheckoutPageAsset;
use kartik\form\ActiveForm;

OrderCheckoutPageAsset::register($this);
ActivePages::setActiveUser();

$h1 = 'Оформлення замовлення';
$breadcrumbItemActive = 'Оформлення замовлення';

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'h1' => $h1,
            'breadcrumbItemActive' => $breadcrumbItemActive,
        ]) ?>
    <?php $form = ActiveForm::begin(['options' => ['autocomplete' => "off"]]); ?>
    <div class="checkout block">
        <div class="container">
            <div class="row">
                <?= $this->render('checkout-delivery', [
                    'form' => $form,
                    'order' => $order,
                    'areas' => $areas,
                    'contacts' => $contacts,
                ]) ?>
                <?= $this->render('checkout-order', [
                    'orders' => $orders,
                    'total_summ' => $total_summ,
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>