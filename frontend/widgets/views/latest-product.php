<?php

use yii\helpers\Url;

?>
<div class="block-sidebar__item">
    <div class="widget-posts widget">
        <h4 class="widget__title"><?= Yii::t('app', $title) ?></h4>
        <div class="widget-products__list">
            <?php foreach ($products as $product): ?>
                <hr>
                <div class="widget-products__item">
                    <div class="widget-products__image">
                        <div class="product-image">
                            <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"
                               class="product-image__body">
                                <img class="product-image__img"
                                     src="<?= $product->getImgOneExtraSmal($product->getId()) ?>"
                                     width="50" height="50"
                                     alt="<?= $product->name ?>">
                            </a>
                        </div>
                    </div>
                    <div class="widget-products__info">
                        <div class="widget-products__name" style="font-weight: 550;">
                            <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $product->name ?></a>
                        </div>
                        <div class="product-card__rating">
                            <div class="product-card__rating-stars">
                                <?= $product->getRating($product->id, 13, 12) ?>
                            </div>
                            <div class="product-card__rating-legend"><?= count($product->reviews) ?>
                                <?=Yii::t('app', 'відгуків')?>
                            </div>
                        </div>
                        <div class="product-card__availability">
                                                         <span class="text-success">
                                                 <?= $this->render('@frontend/widgets/views/status', ['product' => $product]) ?>
                                                         </span>
                        </div>
                        <?php if ($product->old_price == null) { ?>
                            <div class="widget-products__prices" style="font-size: 15px;">
                                <?= Yii::$app->formatter->asCurrency($product->getPrice()) ?>
                            </div>
                        <?php } else { ?>
                            <div class="widget-products__prices">
                                <span class="widget-products__new-price"><?= Yii::$app->formatter->asCurrency($product->getPrice()) ?></span>
                                <span class="widget-products__old-price"><?= Yii::$app->formatter->asCurrency($product->getOldPrice()) ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
