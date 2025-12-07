<?php

use common\models\shop\Brand;
use common\models\shop\Product;

/** @var Brand $img_brand */
/** @var Product $isset_to_cart */
/** @var Product $product */
/** @var Product $products_analog_count */
/** @var Product $mobile */
/** @var $minimumOrderAmount */


?>
<div class="product__sidebar">
    <div class="product__availability"
         style="text-align: center; font-size: 1.5rem; font-weight: 600; letter-spacing: 1px;">
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
    <?php if ($products_analog_count > 0 && $product->status_id == 2) : ?>
        <div class="product-card__badge--analog"
             style="text-align: center"><?= Yii::t('app', 'Але є аналоги') . ' ' . $products_analog_count ?></div>
    <?php endif; ?>
    <div class="product__prices" style="text-align: center">
        <?php $price = Yii::$app->formatter->asCurrency($product->getPrice()) ?>
        <?php if ($product->old_price == null) { ?>
            <div class="product-card__prices">
                <?= $price ?>
            </div>
        <?php } else { ?>
            <div class="product-card__prices">
                <span class="product-card__new-price"><?= $price ?></span>
                <span class="product-card__old-price"><?= Yii::$app->formatter->asCurrency($product->getOldPrice()) ?></span>
            </div>
        <?php } ?>
    </div>
    <div class="product__options">
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
                    <button class="<?= $buttonClass ?> btn-lg shadow_element"
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
                <div class="product__actions-item product__actions-item--wishlist ml-auto">
                    <button type="button"
                            class="btn btn-light btn-svg-icon btn-lg btn-svg-icon--fake-svg product-card__wish"
                            aria-label="add wish list"
                            id="add-from-wish-btn-<?= $product->id ?>"
                            data-url-wish="<?= Yii::$app->urlManager->createUrl(['wish/add-to-wish']) ?>"
                            data-wish-product-id="<?= $product->id ?>">
                        <svg width="32px" height="32px">
                            <use xlink:href="/images/sprite.svg#wishlist-16"></use>
                        </svg>
                    </button>
                </div>
                <div class="product__actions-item product__actions-item--compare">
                    <button type="button"
                            class="btn btn-light btn-svg-icon btn-lg btn-svg-icon--fake-svg product-card__compare"
                            aria-label="add compare list"
                            id="add-from-compare-btn-<?= $product->id ?>"
                            data-url-compare="<?= Yii::$app->urlManager->createUrl(['compare/add-to-compare']) ?>"
                            data-compare-product-id="<?= $product->id ?>">
                        <svg width="32px" height="32px">
                            <use xlink:href="/images/sprite.svg#compare-16"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php if ($product->price < $minimumOrderAmount): ?>
        <div class="product__terms-purchase">
            <span class="product__terms-text"><?=Yii::t('app','Мінімальне замовлення на сайті від')?></span>
            <span class="product__terms-amount"><?= $minimumOrderAmount ?> грн.</span>
        </div>
        <style>
            .product__terms-purchase {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                border: 2px solid #4CAF50;
                border-radius: 8px;
                padding: 10px 15px;
                margin: 20px 0;
                background: linear-gradient(135deg, #e0f7da, #c8e6c9);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            }

            .product__terms-text {
                font-size: 16px;
                color: #333;
                font-weight: 500;
            }

            .product__terms-amount {
                font-size: 18px;
                font-weight: bold;
                color: #f35824;
                margin-top: 5px;
            }
        </style>
    <?php endif; ?>
    <?php if ($product->brand_id === 38): ?>
        <div class="product__terms-purchase">
            <span class="product__terms-text"><?=Yii::t('app','Від 10 п.о доставка насіння')?></span>
            <span class="product__terms-free"><?=Yii::t('app','БЕЗКОШТОВНА')?></span>
        </div>
        <style>
            .product__terms-purchase {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                border: 2px solid #4CAF50;
                border-radius: 8px;
                padding: 10px 15px;
                margin: 20px 0;
                background: linear-gradient(135deg, #e0f7da, #c8e6c9);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            }

            .product__terms-text {
                font-size: 16px;
                color: #333;
                font-weight: 500;
            }

            .product__terms-free {
                font-size: 18px;
                font-weight: bold;
                color: #f35824;
                margin-top: 5px;
            }
        </style>
    <?php endif; ?>
    <?php if (!$mobile): ?>
        <?= $this->render('info-accordion', [
            'product' => $product,
            'mobile' => $mobile,
            'img_brand' => $img_brand,
        ]) ?>
    <?php endif; ?>
</div>