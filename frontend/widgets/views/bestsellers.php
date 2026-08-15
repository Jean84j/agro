<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \common\models\shop\Product $products */
/** @var $title */

$backgroundColorClass ?? $backgroundColorClass = '';
$backgroundColor ?? $backgroundColor = '#a3a397a1';
$borderColor ?? $borderColor = '#f5962ecc';

?>
<div class="block block-products block-products--layout--large-first" data-mobile-grid-columns="2">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title highlight_<?= $backgroundColorClass ?>"><?= Yii::t('app', $title) ?></h3>
            <div class="block-header__divider line-color_<?= $backgroundColorClass ?>"></div>
        </div>
        <div class="block-products__body">
            <div class="block-products__featured">
                <div class="block-products__featured-item">
                    <div class="product-card product-card--hidden-actions ">
                        <?= $this->render('/_partials/quickview-button', ['product' => $products[0]]) ?>
                        <div class="product-card__badges-list">
                            <?php if (isset($products[0]->label->name)) : ?>
                                <div class="product-card__badges-list">
                                    <div class="product-card__badge product-card__badge--new"
                                         style="background: <?= Html::encode($products[0]->label->color) ?>;">
                                        <?= $products[0]->label->name ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="product-card__image product-image">
                            <a href="<?= Url::to(['product/view', 'slug' => $products[0]->slug]) ?>"
                               class="product-image__body">
                                <img class="product-image__img"
                                     src="<?= $products[0]->getImgOneExtraExtraLarge($products[0]->getId()) ?>"
                                     width="348" height="348"
                                     alt="<?= $products[0]->name ?>"
                                     loading="lazy">
                            </a>
                        </div>
                        <div class="product-card__info">
                            <?php if ($products[0]->category->prefix) { ?>
                                <div class="product-card__name">
                                    <?php echo $products[0]->category->prefix ? '<span class="category-prefix">' . $products[0]->category->prefix . '</span>' : '' ?>
                                </div>
                            <?php } ?>
                            <div class="product-card__name">
                                <a href="<?= Url::to(['product/view', 'slug' => $products[0]->slug]) ?>"><?= $products[0]->name ?></a>
                            </div>
                            <div class="product-card__rating">
                                <div class="product-card__rating-stars">
                                    <?= $products[0]->getRating($products[0]->id, 13, 12) ?>
                                </div>
                                <div class="product-card__rating-legend"><?= count($products[0]->reviews) ?>
                                    <?= Yii::t('app', 'відгуків') ?>
                                </div>
                            </div>
                        </div>
                        <div class="product-card__actions">
                            <?= $this->render('/_partials/status', ['product' => $products[0]]) ?>
                            <?= $this->render('/_partials/price', ['product' => $products[0]]) ?>
                            <?= $this->render('/_partials/add-to-cart-button', ['product' => $products[0]]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-products__list">
                <?php $i = 0; ?>
                <?php foreach ($products as $product): ?>
                    <?php if ($i != 0): ?>
                        <div class="block-products__list-item">
                            <div class="product-card product-card--hidden-actions ">
                                <?= $this->render('/_partials/quickview-button', ['product' => $product]) ?>
                                <?= $this->render('/_partials/badges-list', ['product' => $product]) ?>
                                <div class="product-card__image product-image">
                                    <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"
                                       class="product-image__body">
                                        <img class="product-image__img"
                                             src="<?= $product->getImgOneLarge($product->getId()) ?>"
                                             width="193" height="193"
                                             alt="<?= $product->name ?>"
                                             loading="lazy">
                                    </a>
                                </div>
                                <div class="product-card__info">
                                    <?php if ($product->category->prefix) { ?>
                                        <div class="product-card__name">
                                            <?php echo $product->category->prefix ? '<span class="category-prefix">' . $product->category->prefix . '</span>' : '' ?>
                                        </div>
                                    <?php } ?>
                                    <div class="product-card__name">
                                        <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $product->name ?></a>
                                    </div>
                                    <div class="product-card__rating">
                                        <div class="product-card__rating-stars">
                                            <?= $product->getRating($product->id, 13, 12) ?>
                                        </div>
                                        <div class="product-card__rating-legend"><?= count($product->reviews) ?>
                                            <?= Yii::t('app', 'відгуків') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-card__actions">
                                    <?= $this->render('/_partials/status', ['product' => $product]) ?>
                                    <?= $this->render('/_partials/price', ['product' => $product]) ?>
                                    <?= $this->render('/_partials/add-to-cart-button', ['product' => $product]) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php $i++ ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<style>
    .highlight_<?= $backgroundColorClass ?> {
        background-color: <?= $backgroundColor ?>;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid<?= $borderColor ?>;
        display: inline-block;
    }

    .line-color_<?= $backgroundColorClass ?> {
        background-color: <?= $backgroundColor ?>;
    }
</style>