<?php

use common\models\shop\ActivePages;
use frontend\assets\OrderCheckoutPageAsset;
use kartik\form\ActiveForm;

OrderCheckoutPageAsset::register($this);
ActivePages::setActiveUser();

$this->title = Yii::t('app', 'Оформлення замовлення');
?>
<div class="site__body">
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/"> <i class="fas fa-home"></i> <?= Yii::t('app', 'Головна') ?> </a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $this->title ?></li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1><?= $this->title ?></h1>
            </div>
        </div>
    </div>
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