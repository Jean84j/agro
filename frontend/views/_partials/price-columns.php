<?php

/** @var $product */

?>
<div class="product-card__prices">
    <?php if ($product->old_price == null) { ?>
        <?php $style = 'margin-left: 80px' ?>
        <?= Yii::$app->formatter->asCurrency($product->getPrice()) ?>
    <?php } else { ?>
        <?php $style = 'margin-left: 10px' ?>
        <span class="product-card__new-price"><?= Yii::$app->formatter->asCurrency($product->getPrice()) ?></span>
        <span class="product-card__old-price"><?= Yii::$app->formatter->asCurrency($product->getOldPrice()) ?></span>
    <?php } ?>
    <button type="button"
            class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wish"
            aria-label="add wish list"
            style="width: 20px; height: 20px; <?= $style ?>;"
            data-url-wish="<?= Yii::$app->urlManager->createUrl(['wish/add-to-wish']) ?>"
            data-wish-product-id="<?= $product->id ?>">
        <svg width="16px" height="16px">
            <use xlink:href="/images/sprite.svg#wishlist-16"></use>
        </svg>
    </button>
    <button type="button"
            class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare"
            aria-label="add compare list"
            style="width: 20px; height: 20px;"
            data-url-compare="<?= Yii::$app->urlManager->createUrl(['compare/add-to-compare']) ?>"
            data-compare-product-id="<?= $product->id ?>">
        <svg width="16px" height="16px">
            <use xlink:href="/images/sprite.svg#compare-16"></use>
        </svg>
    </button>
</div>
