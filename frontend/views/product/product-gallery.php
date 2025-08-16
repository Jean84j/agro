<?php

use yii\helpers\Html;

?>
<div class="product__gallery">
    <div class="product-gallery">
        <?php if (!empty($product->images)) : ?>
            <div class="product-gallery__featured">
                <div>
                    <div class="skeleton-loader"  style="padding: 20px;">
                            <img src="<?= '/product/' . $product->images[0]->extra_extra_large ?>"
                                 width="336" height="336"
                                 alt="<?= $product->name ?>">
                    </div>
                </div>
                <button class="product-gallery__zoom" aria-label="Збільшити">
                    <svg width="24px" height="24px">
                        <use xlink:href="/images/sprite.svg#zoom-in-24"></use>
                    </svg>
                </button>
                <div class="owl-carousel" id="product-image">
                    <?php foreach ($images as $image) : ?>
                        <?php if ($webp_support == true && isset($image->webp_extra_extra_large)) { ?>
                            <div class="product-image product-image--location--gallery">
                                <div class="product-card__badges-list">
                                    <?php if (isset($product->label->name)) : ?>
                                        <div class="product-card__badge product-card__badge--sale"
                                             style="background: <?= Html::encode($product->label->color) ?>">
                                            <?= $product->label->name ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($products_analog_count > 0) : ?>
                                        <div class="product-card__badge product-card__badge--analog">
                                            <?= Yii::t('app', 'Є аналоги') . ' ' . $products_analog_count ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <a href="<?= '/product/' . $image->webp_name ?>" data-width="700"
                                   data-height="700" class="product-image__body" target="_blank">
                                    <img class="product-image__img"
                                         src="<?= '/product/' . $image->webp_extra_extra_large ?>"
                                         width="336" height="336"
                                         alt="<?= $product->name ?>">
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="product-image product-image--location--gallery">
                                <div class="product-card__badges-list">
                                    <?php if (isset($product->label->name)) : ?>
                                        <div class="product-card__badge product-card__badge--new">
                                            <?= $product->label->name ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <a href="<?= '/product/' . $image->name ?>" data-width="700"
                                   data-height="700" class="product-image__body" target="_blank">
                                    <img class="product-image__img"
                                         src="<?= '/product/' . $image->extra_extra_large ?>"
                                         width="336" height="336"
                                         alt="<?= $product->name ?>">
                                </a>
                            </div>
                        <?php } ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="product-gallery__carousel">
                <div class="owl-carousel" id="product-carousel">
                    <?php foreach ($images as $image) : ?>
                    <a href="<?= '/product/' . $image->name ?>" class="product-image product-gallery__carousel-item">
                        <div class="product-image__body">
                            <img class="product-image__img product-gallery__carousel-image" 
                            src="<?= '/product/' . $image->name ?>" 
                            alt="<?= $product->name ?>">
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (!$mobile): ?>
            <?php if ($this->beginCache('tags-product_' . $language . $product->id, ['duration' => 3600])): ?>
                <?= $this->render('tags', [
                    'product' => $product,
                    'language' => $language,
                ]) ?>
                <?php $this->endCache() ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>