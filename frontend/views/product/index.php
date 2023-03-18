<?php
/** @var yii\web\View $this */
/** @var \common\models\shop\Product $product */

/** @var \common\models\shop\Product $products */

use yii\helpers\Url;
use frontend\widgets\RelatedProducts;

$this->title = Yii::$app->name;
?>
<!-- site__body -->
<div class="site__body">
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">Головна</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= Url::to(['category/list']) ?>">Категорії</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <?php if (isset($product->category->parent)): ?>
                            <li class="breadcrumb-item">
                                <a href="<?= Url::to(['category/children', 'slug' => $product->category->parent->slug]) ?>"><?= $product->category->parent->name ?></a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                        <?php endif; ?>
                        <li class="breadcrumb-item">
                            <a href="<?= Url::to(['category/catalog', 'slug' => $product->category->slug]) ?>"><?= $product->category->name ?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $product->name ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="product product--layout--standard" data-layout="standard">
                <div class="product__content">
                    <!-- .product__gallery -->
                    <div class="product__gallery">
                        <div class="product-gallery">
                            <?php if (!empty($product->images)) : ?>
                                <div class="product-gallery__featured">

                                    <button class="product-gallery__zoom">
                                        <svg width="24px" height="24px">
                                            <use xlink:href="/images/sprite.svg#zoom-in-24"></use>
                                        </svg>
                                    </button>
                                    <div class="owl-carousel" id="product-image">
                                        <?php foreach ($product->images as $image) : ?>
                                            <div class="product-image product-image--location--gallery">
                                                <a href="<?= '/product/' . $image->name ?>" data-width="700"
                                                   data-height="700" class="product-image__body" target="_blank">
                                                    <img class="product-image__img" src="
                                                 <?= '/product/' . $image->name ?>
                                                " alt="<?= $image->name ?>">
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="product-gallery__carousel">
                                    <div class="owl-carousel" id="product-carousel">
                                        <?php foreach ($product->images as $image) : ?>
                                            <a href="/images/products/product-16-4.jpg"
                                               class="product-image product-gallery__carousel-item">
                                                <div class="product-image__body">
                                                    <img class="product-image__img product-gallery__carousel-image"
                                                         src="<?= '/product/' . $image->name ?>"
                                                         alt="<?= $image->name ?>">
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="product-gallery__featured">
                                    <button class="product-gallery__zoom">
                                        <svg width="24px" height="24px">
                                            <use xlink:href="/images/sprite.svg#zoom-in-24"></use>
                                        </svg>
                                    </button>
                                    <div class="owl-carousel" id="product-image">
                                        <div class="product-image product-image--location--gallery">
                                            <a href="/product/no-image.png" data-width="700" data-height="700"
                                               class="product-image__body" target="_blank">
                                                <img class="product-image__img" src="/product/no-image.png"
                                                     alt="no image">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- .product__gallery / end -->
                    <!-- .product__info -->
                    <div class="product__info">
                        <div class="product__wishlist-compare">
                            <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip"
                                    data-placement="right" title="Wishlist">
                                <svg width="16px" height="16px">
                                    <use xlink:href="/images/sprite.svg#wishlist-16"></use>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip"
                                    data-placement="right" title="Compare">
                                <svg width="16px" height="16px">
                                    <use xlink:href="/images/sprite.svg#compare-16"></use>
                                </svg>
                            </button>
                        </div>
                        <h1 class="product__name"><?= $product->name ?></h1>
                        <div class="product__description"><?= $product->short_description ?>
                        </div>
                        <ul class="product__meta">
                            <li class="product__meta-availability"><span
                            <?php if ($product->status->name == 'В наявності'): ?>
                                <li><span class="p-3 mb-2 bg-success text-white"><?= $product->status->name ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if ($product->status->name == 'Немає в наявності'): ?>
                                <li><span class="p-3 mb-2 bg-danger text-white"><?= $product->status->name ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if ($product->status->name == 'Очікується'): ?>
                                <li><span class="p-3 mb-2 bg-warning text-dark"><?= $product->status->name ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if ($product->status->name == 'Під замовлення'): ?>
                                <li><span class="p-3 mb-2 bg-info text-white"><?= $product->status->name ?></span></li>
                            <?php endif; ?>
                            <li><a href=""> </a></li>
                            <li class="payment-methods__item" style="background: #ffe484;padding: 10px;color: black;">
                                Артикул: <span style="margin-right: 10px;" id="sku">0000<?= $product->id ?> </span>
                            </li>
                        </ul>
                    </div>
                    <!-- .product__info / end -->
                    <!-- .product__sidebar -->
                    <div class="product__sidebar">
                        <div class="product__availability">
                            Availability: <span class="text-success">In Stock</span>
                        </div>
                        <div class="product__prices">
                            <?= Yii::$app->formatter->asCurrency($product->price) ?>
                        </div>
                        <!-- .product__options -->
                        <form class="product__options">
                            <?php if ($product->tags): ?>
                                <div class="form-group product__option">
                                    <label class="product__option-label">Теги</label>
                                    <div class="input-radio-label">
                                        <div class="input-radio-label__list">
                                            <?php foreach ($product->tags as $tag): ?>
                                                <label>
                                                    <input type="radio" name="tag-<?= $tag->name ?>">
                                                    <span><?= $tag->name ?></span>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group product__option">
                                <label class="product__option-label" for="product-quantity">Кількість</label>
                                <div class="product__actions">
                                    <div class="product__actions-item">
                                        <div class="input-number product__quantity">
                                            <input id="product-quantity"
                                                   class="input-number__input form-control form-control-lg"
                                                   type="number" min="1" value="1">
                                            <div class="input-number__add"></div>
                                            <div class="input-number__sub"></div>
                                        </div>
                                    </div>
                                    <div class="product__actions-item product__actions-item--addtocart">
                                        <button class="btn btn-primary btn-lg">Купити</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- .product__options / end -->
                    </div>
                    <!-- .product__end -->
                </div>
            </div>
            <!-- description -->
            <?= $this->render('description', ['product' => $product]) ?>
            <!-- description /end -->
        </div>
    </div>
    <!-- .block-products-carousel -->
    <?php echo RelatedProducts::widget() ?>
    <!-- .block-products-carousel / end -->
</div>
<!-- site__body / end -->