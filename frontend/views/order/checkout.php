<?php

use common\models\ActivePages;
use frontend\assets\OrderCheckoutPageAsset;
use frontend\widgets\ViewProduct;
use kartik\form\ActiveForm;

/** @var  $order */
/** @var  $orders */
/** @var  $form */
/** @var  $areas */
/** @var  $contacts */
/** @var  $total_summ */
/** @var  $minimumOrderAmount */

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
                    'minimumOrderAmount' => $minimumOrderAmount,
                ]) ?>
            </div>
        </div>
    </div>
    <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
    <?php ActiveForm::end(); ?>
</div>