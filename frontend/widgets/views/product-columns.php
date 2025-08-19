<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var \common\models\shop\Product $products */

?>
<div class="col-4">
    <div class="block-header">
        <a href="<?= $url ?>">
            <h3 class="block-header__title"><?= Yii::t('app', $title) ?></h3>
        </a>
        <div class="block-header__divider"></div>
    </div>
    <div class="block-product-columns__column">
        <?php foreach ($products as $product): ?>
            <div class="block-product-columns__item">
                <div class="product-card product-card--hidden-actions product-card--layout--horizontal">
                    <?= $this->render('@frontend/views/_partials/quickview-button', ['product' => $product]) ?>
                    <?php if (isset($product->label)): ?>
                        <div class="product-card__badges-list">
                            <div class="product-card__badge product-card__badge--new"
                                 style="background: <?= Html::encode($product->label->color) ?>;">
                                <?= $product->label->name ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="product-card__image product-image">
                        <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"
                           class="product-image__body">
                            <img class="product-image__img"
                                 src="<?= $product->getImgOneSmall($product->getId()) ?>"
                                 width="88" height="88"
                                 alt="<?= $product->name ?>"
                                 loading="lazy">
                        </a>
                    </div>
                    <div class="product-card__info">
                        <div class="product-card__name">
                            <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $product->name ?></a>
                        </div>
                        <div class="product-card__rating">
                            <div class="product-card__rating-stars">
                                <?= $product->getRating($product->id, 13, 12) ?>
                            </div>
                            <div class="product-card__rating-legend"><?= count($product->reviews) ?>
                                <?= Yii::t('app', 'відгуків') ?></div>
                        </div>
                    </div>
                    <div class="product-card__actions">
                        <div class="product-card__availability">
                            <?= $this->render('@frontend/views/_partials/status', ['product' => $product]) ?>
                        </div>
                        <div class="product-card__prices">
                            <?php if ($product->old_price == null) { ?>
                                <?= Yii::$app->formatter->asCurrency($product->getPrice()) ?>
                                <button type="button"
                                        class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wish"
                                        aria-label="add wish list"
                                        style="width: 20px; height: 20px; margin-left: 80px;"
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
                            <?php } else { ?>
                                <span class="product-card__new-price"><?= Yii::$app->formatter->asCurrency($product->getPrice()) ?></span>
                                <span class="product-card__old-price"><?= Yii::$app->formatter->asCurrency($product->getOldPrice()) ?></span>
                                <button type="button"
                                        class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wish"
                                        aria-label="add wish list"
                                        style="width: 20px; height: 20px; margin-left: 10px;"
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
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>