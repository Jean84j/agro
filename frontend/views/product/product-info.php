<?php

use yii\helpers\Url;

/** @var $product */
/** @var $productVariants */
/** @var $mobile */
/** @var $language */
/** @var $product_properties */

?>
<div class="product__info">
    <div class="product__wishlist-compare">
        <button type="button"
                class="btn btn-sm btn-light btn-svg-icon product-card__wish"
                aria-label="add wish list"
                id="add-from-wish-btn-<?= $product->id ?>"
                data-url-wish="<?= Yii::$app->urlManager->createUrl(['wish/add-to-wish']) ?>"
                data-wish-product-id="<?= $product->id ?>">
            <svg width="16px" height="16px">
                <use xlink:href="/images/sprite.svg#wishlist-16"></use>
            </svg>
        </button>
        <button type="button"
                class="btn btn-sm btn-light btn-svg-icon product-card__compare"
                aria-label="add compare list"
                id="add-from-compare-btn-<?= $product->id ?>"
                data-url-compare="<?= Yii::$app->urlManager->createUrl(['compare/add-to-compare']) ?>"
                data-compare-product-id="<?= $product->id ?>">
            <svg width="16px" height="16px">
                <use xlink:href="/images/sprite.svg#compare-16"></use>
            </svg>
        </button>
    </div>
    <h1 class="product__name">
        <?php if ($product->h1): ?>
            <?= $product->h1 ?>
        <?php else: ?>
            <?php if ($product->category->prefix): ?>
                <span class="category-prefix"><?= $product->category->prefix ?></span><br>
            <?php endif; ?>
            <?= $product->name ?>
        <?php endif; ?>
    </h1>
    <div class="product__rating">
        <div class="product__rating-stars">
            <?= $product->getRating($product->id) ?>
        </div>
        <div class="product__rating-legend">
            <?= $product->getRatingCount($product->id) ?>
        </div>
    </div>
    <?php if ($productVariants): ?>
        <div class="mt-3 mb-3" style="font-size: 14px; color: #a6a7a6">
            <div class="packaging">
                <span><?=Yii::t('app','фасування')?>:</span>
            </div>
            <?php foreach ($productVariants as $variant): ?>
                <?php
                $statusClass = ($variant['status_id'] === 2) ? 'btn-outline-secondary' : 'btn-outline-success';
                $isDisabled = ($variant['status_id'] === 2) ? 'disabled' : '';
                $slugUrl = Url::to(['product/view', 'slug' => $variant['slug']]);
                ?>
                <button class="btn btn-sm shadow_element <?= $statusClass ?>"
                        onclick="window.location.href='<?= $slugUrl ?>'"
                    <?= $isDisabled ?>>
            <span class="<?= $variant['status_id'] === 2 ? '' : 'font-weight-bold' ?>">
                <?= $variant['volume']; ?>
            </span>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (!$mobile): ?>
        <div class="product__description">
            <?= $this->render('properties', [
                'product_properties' => $product_properties,
                'productId' => $product->id,
                'language' => $language,
            ]) ?>
        </div>
    <?php endif; ?>
</div>