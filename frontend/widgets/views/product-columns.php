<?php

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
                    <?= $this->render('/_partials/quickview-button', ['product' => $product]) ?>
                    <?= $this->render('/_partials/badges-list', ['product' => $product]) ?>
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
                        <?= $this->render('/_partials/status', ['product' => $product]) ?>
                        <?= $this->render('/_partials/price-columns', ['product' => $product]) ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>