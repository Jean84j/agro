<?php

use common\models\shop\Product;
use yii\helpers\Url;

?>
<div class="quickview">
    <button class="quickview__close" type="button">
        <svg width="20px" height="20px">
            <use xlink:href="/images/sprite.svg#cross-20"></use>
        </svg>
    </button>
    <div class="product product--layout--quickview" data-layout="quickview">
        <div class="product__content">
            <div class="product__gallery">
                <div class="product-gallery">
                    <div class="product-gallery__featured">
                        <div class="product-image product-image--location--gallery">
                                <span data-width="700" data-height="700" class="product-image__body">
                                    <img class="product-image__img" src="<?= $product->getImgOne($product->id) ?>"
                                         alt="<?= $product->name ?>">
                                </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product__info">
                <h1 class="product__name">
                    <?php if ($product->category->prefix): ?>
                        <span class="category-prefix"><?= $product->category->prefix ?></span><br>
                    <?php endif; ?>
                    <?= $product->name ?>
                </h1>
                <div class="product__rating">
                    <div class="product__rating-stars">
                        <?= $product->getRating($product->id) ?>
                    </div>
                    <div class="product__rating-legend">
                        <?= $product->getRatingCount($product->id) ?>
                    </div>
                </div>
                <div class="product__description">
                    <?= mb_strlen($product->short_description) > 200 ? mb_substr($product->short_description, 0, 200) . '...' : $product->short_description ?>
                </div>
                <ul class="product-card__features-list">
                    <?= Product::productParamsList($product->id) ?>
                </ul>
                <ul class="product__meta">
                    <li><?= Yii::t('app', 'Бренд') ?>:
                        <a href="<?= Url::to(['brands/catalog', 'slug' => $product->brand->slug ?? 'agropro']) ?>">
                            <span style="font-weight: bold">
                            <?= $product->brand->name ?? 'AgroPro' ?>
                            </span>
                        </a>
                    </li>
                    <li>SKU: <span style="font-weight: bold"><?= $product->sku ?></span></li>
                </ul>
            </div>
            <div class="product__sidebar">
                <div class="product__availability"
                     style="font-size: 1.5rem; font-weight: 600; letter-spacing: 1px;">
                    <?php
                    $statuses = [
                        1 => ['icon' => 'fas fa-check', 'color' => '#28a745'],
                        2 => ['icon' => 'fas fa-ban', 'color' => '#ff0000'],
                        3 => ['icon' => 'fas fa-truck', 'color' => '#ff8300'],
                        4 => ['icon' => 'fa fa-bars', 'color' => '#0331fc'],
                    ];

                    $status = $statuses[$product->status_id] ?? ['icon' => '', 'color' => '#060505'];
                    $statusIcon = $status['icon'] ? '<i style="margin: 5px; color: ' . $status['color'] . ';" class="' . $status['icon'] . '"></i>' : '';
                    $statusStyle = 'color: ' . $status['color'] . ';';

                    echo $statusIcon . '<span style="' . $statusStyle . '">' . Yii::t('app', $product->status->name) . '</span>';
                    ?>
                </div>
                <div class="product__prices">
                    <?= Yii::$app->formatter->asCurrency($product->getPrice()) ?>
                </div>
                <form class="product__options">
                    <div class="form-group product__option">
                        <div class="product__actions">
                            <div class="product__actions-item product__actions-item--addtocart">
                                <?php
                                $isAvailable = $product->status_id != 2;
                                $buttonClass = $isAvailable ? 'btn btn-primary product-card__addtocart' : 'btn btn-secondary product-card__addtocart';
                                $buttonText = $isAvailable
                                    ? (!$product->getIssetToCart($product->id) ? Yii::t('app', 'Купити') : Yii::t('app', 'В кошику'))
                                    : Yii::t('app', 'Купити');
                                ?>
                                <button class="<?= $buttonClass ?> btn-lg"
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
                            </div>
                            <div class="product__actions-item product__actions-item--wishlist">
                                <button type="button" class="btn btn-secondary btn-svg-icon btn-lg product-card__wish"
                                        data-toggle="tooltip"
                                        title="Wishlist"
                                        id="add-from-wish-btn-<?= $product->id ?>"
                                        data-url-wish="<?= Yii::$app->urlManager->createUrl(['wish/add-to-wish']) ?>"
                                        data-wish-product-id="<?= $product->id ?>">
                                    <svg width="16px" height="16px">
                                        <use xlink:href="/images/sprite.svg#wishlist-16"></use>
                                    </svg>
                                </button>
                            </div>
                            <div class="product__actions-item product__actions-item--compare">
                                <button type="button" class="btn btn-secondary btn-svg-icon btn-lg product-card__compare"
                                        data-toggle="tooltip"
                                        title="Compare"
                                        id="add-from-compare-btn-<?= $product->id ?>"
                                        data-url-compare="<?= Yii::$app->urlManager->createUrl(['compare/add-to-compare']) ?>"
                                        data-compare-product-id="<?= $product->id ?>">
                                    <svg width="16px" height="16px">
                                        <use xlink:href="/images/sprite.svg#compare-16"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="product__footer">
                <div class="product__tags tags">
                    <div class="tags__list">
                        <?php foreach ($product->tags as $tag): ?>
                            <a href="<?= Url::to(['tag/view', 'slug' => $tag->slug]) ?>"><?= $tag->getTagTranslate($tag, $language) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .param-item {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        line-height: 1.4;
    }
</style>