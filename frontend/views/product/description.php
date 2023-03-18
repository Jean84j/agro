<?php

use yii\helpers\Url;

/** @var \common\models\shop\Product $product */

?>

<div class="product-tabs  product-tabs--sticky">
    <div class="product-tabs__list">
        <div class="product-tabs__list-body">
            <div class="product-tabs__list-container container">
                <a href="#tab-description" class="product-tabs__item product-tabs__item--active">Опис</a>
            </div>
        </div>
    </div>
    <div class="product-tabs__content">
        <div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
            <div class="typography">
                <?= $product->description ?>
            </div>
        </div>
    </div>
</div>
                