<?php

/** @var Product $product */

use common\models\shop\Product;

?>
<div class="product-card__buttons">
    <?php
    $isAvailable = $product->status_id != 2;
    $buttonClass = $isAvailable ? 'btn btn-primary product-card__addtocart' : 'btn btn-secondary product-card__addtocart';
    $buttonText = $isAvailable
        ? (!$product->getIssetToCart($product->id) ? Yii::t('app', 'Купити') : Yii::t('app', 'В кошику'))
        : Yii::t('app', 'Купити');
    ?>
    <button class="<?= $buttonClass ?>"
            type="button"
            id="<?= $isAvailable ? 'add-to-cart' : '' ?>"
            data-product-id="<?= $product->id ?>"
            data-url-cart-view="<?= $isAvailable ? Yii::$app->urlManager->createUrl(['cart/cart-view']) : '' ?>"
            data-url-qty-cart="<?= $isAvailable ? Yii::$app->urlManager->createUrl(['cart/qty-cart']) : '' ?>"
        <?= $isAvailable ? '' : 'disabled' ?>>
        <svg width="20px" height="20px" style="display: unset;">
            <use xlink:href="/images/sprite.svg#cart-20"></use>
        </svg>
        <?= $buttonText ?>
    </button>
    <button type="button"
            class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wish"
            aria-label="add wish list"
            data-url-wish="<?= Yii::$app->urlManager->createUrl(['wish/add-to-wish']) ?>"
            data-wish-product-id="<?= $product->id ?>">
        <svg width="20px" height="20px">
            <use xlink:href="/images/sprite.svg#wishlist-16"></use>
        </svg>
    </button>
    <button type="button"
            class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare"
            aria-label="add compare list"
            data-url-compare="<?= Yii::$app->urlManager->createUrl(['compare/add-to-compare']) ?>"
            data-compare-product-id="<?= $product->id ?>">
        <svg width="20px" height="20px">
            <use xlink:href="/images/sprite.svg#compare-16"></use>
        </svg>
    </button>
</div>