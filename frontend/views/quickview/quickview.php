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
                <?= $this->render('/_partials/status', ['product' => $product]) ?>
                <div class="product__prices">
                    <?= Yii::$app->formatter->asCurrency($product->getPrice()) ?>
                </div>
                <form class="product__options">
                    <div class="form-group product__option">
                        <div class="product__actions">
                            <div class="product__actions-item product__actions-item--addtocart">
                                <?= $this->render('/_partials/add-to-cart-button', ['product' => $product]) ?>
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