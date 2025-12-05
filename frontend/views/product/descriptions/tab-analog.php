<?php

use common\models\shop\Product;
use yii\helpers\Url;

/** @var  $product */
/** @var  $products_analog */
/** @var  $language */

?>
<div class="product-tabs__pane" id="tab-analog">
    <div class="spec">
        <h2 class="spec__header"><?= Yii::t('app', 'Аналог товару') . ' ' . $product->name ?></h2>
        <?php if ($products_analog) { ?>
            <div class="block-sidebar__item">
                <div class="widget">
                    <div class="widget-products__list">
                        <?php $i = 1;
                        foreach ($products_analog as $product_analog): ?>
                            <div class="products-view__list products-list" data-layout="list"
                                 data-with-features="false" data-mobile-grid-columns="2">
                                <div class="products-list__body">
                                    <div class="products-list__item">
                                        <div class="product-card product-card--hidden-actions ">
                                            <?php if (isset($products_analog->label)): ?>
                                                <div class="product-card__badges-list">
                                                    <div class="product-card__badge product-card__badge--new"><?= $products_analog->label->name ?></div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="product-card__image product-image">
                                                <a href="<?= Url::to(['product/view', 'slug' => $product_analog->slug]) ?>"
                                                   class="product-image__body">
                                                    <img class="product-image__img"
                                                         src="<?= $product_analog->getImgOneExtraLarge($product_analog->getId()) ?>"
                                                         width="162" height="162"
                                                         alt="<?= $product_analog->name ?>"
                                                         loading="lazy">
                                                </a>
                                            </div>
                                            <div class="product-card__info">
                                                <div class="product-card__name">
                                                    <a href="<?= Url::to(['product/view', 'slug' => $product_analog->slug]) ?>"><?= $product_analog->name ?></a>
                                                </div>
                                                <div class="product-card__rating">
                                                    <div class="product-card__rating-stars">
                                                        <div class="rating">
                                                            <div class="rating__body">
                                                                <?= $product_analog->getRating($product_analog->id, 13, 12) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-card__rating-legend"><?= count($product_analog->reviews) ?>
                                                        <?= Yii::t('app', 'відгуків') ?>
                                                    </div>
                                                </div>
                                                <ul class="product-card__features-list">
                                                    <?= Product::productParamsList($product_analog->id) ?>
                                                </ul>
                                            </div>
                                            <div class="product-card__actions">
                                                <div class="product-card__availability">
                                                                     <span class="text-success">
                                                                        <?= $this->render('@frontend/views/_partials/status', ['product' => $product_analog]) ?>
                                                                     </span>
                                                </div>
                                                <?php if ($product_analog->old_price == null) { ?>
                                                    <div class="product-card__prices">
                                                        <?= Yii::$app->formatter->asCurrency($product_analog->getPrice()) ?>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="product-card__prices">
                                                        <span class="widget-products__new-price"><?= Yii::$app->formatter->asCurrency($product_analog->getPrice()) ?></span>
                                                        <span class="widget-products__old-price"><?= Yii::$app->formatter->asCurrency($product_analog->getOldPrice()) ?></span>
                                                    </div>
                                                <?php } ?>
                                                <?= $this->render('@frontend/views/_partials/add-to-cart-button', ['product' => $product_analog]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; endforeach ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="spec__disclaimer">
            <?php if ($language == 'ru'): ?>
                Информация о технических характеристиках, комплекте поставки, стране производителя и внешнем виде товара является справочной и базируется на актуальной на момент публикации информации.
            <?php elseif ($language == 'en'): ?>
                Information about technical specifications, delivery package, country of manufacture and appearance of the product is for reference only and is based on information current at the time of publication.
            <?php else: ?>
                Інформація про характеристики, комплект поставки, країну виробника та зовнішній вигляд товару є довідковою та базується на актуальній на момент публікації інформації.
            <?php endif; ?>
        </div>
    </div>
</div>
