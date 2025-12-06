<?php

/** @var  $product */
/** @var  $arrow */

?>
<div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
    <div class="typography" id="product-description">
        <h2 class="spec__header"><?= Yii::t('app', 'Опис, інструкція товару') . ' ' . $product->name ?></h2>
        <div class="short-description"><?= $product->short_description ?></div>
        <div class="full-description" style="display: none;"><?= $product->description ?></div>
        <div class="footer-description"
             style="display: none;"><?= $product->getFooterDescription($product->footer_description, $product->name) ?></div>
        <button class="btn btn-secondary arrow-right"
                id="show-more-btn"><?= Yii::t('app', 'Розгорнути опис') . $arrow ?></button>
        <button class="btn btn-secondary arrow-left" id="hide-description-btn"
                style="display: none; margin-top: 20px">
            <?= Yii::t('app', 'Приховати опис') . $arrow ?>
        </button>
    </div>
</div>
<style>
    .footer-description {
        background-color: #a2ff0542;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #4DC7A0;
        display: inline-block;
    }
</style>
