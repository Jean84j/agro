<?php

use common\models\shop\Product;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var Product $products */

?>
<div class="products-view__list products-list" data-layout="grid-4-full"
     data-with-features="false" data-mobile-grid-columns="2">
    <div class="products-list__body">
        <?php foreach ($products as $product): ?>
            <div class="products-list__item">
                <div class="product-card product-card--hidden-actions ">
                    <?= $this->render('@frontend/widgets/views/quickview-button.php', ['product' => $product]) ?>
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
                                 src="<?= $product->getImgOne($product->getId()) ?>"
                                 width="231" height="231"
                                 alt="<?= $product->name ?>">
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

                        <ul class="product-card__features-list">
                            <?= Product::productParamsList($product->id) ?>
                        </ul>

                    </div>
                    <div class="product-card__actions">
                        <div class="product-card__availability">
                            <?= $this->render('@frontend/widgets/views/status.php', ['product' => $product]) ?>
                        </div>
                        <?php if ($product->old_price == null) { ?>
                            <div class="product-card__prices">
                                <?= Yii::$app->formatter->asCurrency($product->getPrice()) ?>
                            </div>
                        <?php } else { ?>
                            <div class="product-card__prices">
                                <span class="product-card__new-price"><?= Yii::$app->formatter->asCurrency($product->getPrice()) ?></span>
                                <span class="product-card__old-price"><?= Yii::$app->formatter->asCurrency($product->getOldPrice()) ?></span>
                            </div>
                        <?php } ?>
                        <?= $this->render('@frontend/widgets/views/add-to-cart-button.php', ['product' => $product]) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<style>
    .category-prefix {
        color: #a9a8a8;
    }

    .param-item {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
</style>
