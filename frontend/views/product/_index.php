<?php
/** @var yii\web\View $this */
/** @var \common\models\shop\Product $product */

/** @var \common\models\shop\Product $products */

use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\RelatedProducts;
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
            <div class="product product--layout--columnar" data-layout="columnar">
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
                            <?php else : ?>
                                <div class="product-gallery__featured">
                                    <button class="product-gallery__zoom">
                                        <svg width="24px" height="24px">
                                            <use xlink:href="/images/sprite.svg#zoom-in-24"></use>
                                        </svg>
                                    </button>
                                    <div class="owl-carousel" id="product-image">

                                        <div class="product-image product-image--location--gallery">
                                            <a href="/upload/stock/no-image.png" data-width="700" data-height="700"
                                               class="product-image__body" target="_blank">
                                                <img class="product-image__img" src="/upload/stock/no-image.png"
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

                        <h1 class="product__name"><?= $product->name ?></h1>

                        <div class="product__rating">
                            <div class="product__rating-stars">
                                <div class="rating">
                                    <div class="rating__body">

                                    </div>
                                </div>
                            </div>
                            <div class="product__rating-legend">
                                <a href="#tab-reviews">5.0 (89 оценок)</a>
                            </div>
                        </div>

                        <div class="product__description">
                            <?= $product->short_description ?>
                        </div>


                    </div>
                    <!-- .product__info / end -->
                    <!-- .product__sidebar -->
                    <div class="product__sidebar">
                        <!-- .product__options -->
                        <div class="payment-methods">
                            <ul class="payment-methods__list">
                                <li class="payment-methods__item"
                                    style="background: #ffe484;padding: 10px;color: black;">
                                    Артикул: <span style="margin-right: 10px;" id="sku"><?= $product->id ?> </span>
                                </li>
                                <li class="payment-methods__item payment-methods__item--active">
                                    <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="" type="radio" checked="">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                                        <span class="delivery-methods__item-name"><i style="font-size: 28px"
                                                                                     class="fas fa-truck"></i>
                                            <span style="font-size:20px; margin:0px 20px">Доставка</span></span>
                                    </label>
                                    <div class="payment-methods__item-container" style="">
                                        <div class="payment-methods__item-description text-muted">
                                            <b>Новая почта</b>
                                            <ul>

                                                <li>
                                                    Вартість доставки по тарифу <a
                                                            href="https://novaposhta.ua/ru/basic_tariffs"
                                                            target="_bank">перевізника</a>
                                                </li>
                                            </ul>
                                            <b>Відвантаження з Полтави</b>
                                            <ul>

                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="payment-methods__item">
                                    <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="beznal" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                                        <span class="payment-methods__item-name"><i style="font-size: 28px"
                                                                                    class="fas fa-credit-card"></i> <span
                                                    style="font-size:20px; margin:0px 20px">Спосіб сплати</span></span>
                                    </label>
                                    <div class="payment-methods__item-container" style="">
                                        <div class="payment-methods__item-description text-muted">
                                            <ul>
                                                <li>Сплатити Visa/Mastercard</li>
                                                <li>Оплатити готівкою</li>
                                                <li>Наеладенний платіж</li>
                                                <li>Сплатити на розрахунковий рахунок</li>
                                                <hr>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="payment-methods__item">
                                    <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method"
                                                       value="online" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                                        <span class="shield-methods__item-name"><i style="font-size: 28px"
                                                                                   class="fas fa-shield-alt"></i> <span
                                                    style="font-size:20px; margin:0px 20px">Гарантия</span></span>
                                    </label>
                                    <div class="payment-methods__item-container" style="">
                                        <div class="payment-methods__item-description text-muted">
                                            Гарантія на повернення ознайомтесь будь ласка з<a
                                                    href="/company/vozvrat-i-garantii.html"
                                                    target="_blank">правилами</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- .product__options / end -->
                    </div>
                    <!-- .product__end -->
                    <div class="product__footer">
                        <div class="product__prices">

                            <?php foreach ($product->tags as $brand): ?>
                                <button class="btn btn-secondary btn-xs"><?= $brand->name ?></button>
                            <?php endforeach; ?>
                            <hr>
                            <div class="price" style="margin-bottom: 25px">
                                <?= $product->price ?> &#8372;
                            </div>
                            <div class="product__actions">
                                <div class="product__actions-item">
                                    <div class="input-number product__quantity">
                                        <input id="product-quantity"
                                               class="input-number__input form-control form-control-lg" type="number"
                                               min="1" value="<?= !$isset_to_cart ? '1' : $isset_to_cart['_quantity'] ?>">
                                        <div class="input-number__add"></div>
                                        <div class="input-number__sub"></div>
                                    </div>
                                </div>
                                <!--                                <div class="product__actions-item product__actions-item--addtocart">-->
                                <button class="btn btn-primary product-card__addtocart "
                                        type="button"
                                        data-product-id="<?= $product->id ?>"
                                        style="margin-top: 4px;
                                margin-left: 9px;
                                padding: 9px 39px;
                                height: 47px;">
                                    <svg width="20px" height="20px" style="display: unset;">
                                        <use xlink:href="/images/sprite.svg#cart-20"></use>
                                    </svg>
                                    <?= !$isset_to_cart ? 'В Кошик' : 'Уже в кошику' ?>
                                </button>

                            </div>
                        </div>

                        <!-- <div class="product__actions-item product__actions-item--addtocart"> -->

                    </div>
                    <div class="form-group product__option">
                        Наявність: <span class="text-success" style="padding: 3px 1px">
                                <?php
                                if ($product->status_id == 1) {
                                    echo '<i style="font-size:1.5rem; margin: 5px;" class="fas fa-check"></i> ' . $product->status->name;
                                } elseif ($product->status_id == 2) {
                                    echo '<i style="font-size:1.5rem; color: #ff0000!important; margin: 5px;" class="fas fa-ban"></i> ';
                                    echo "<span style='color: #ff0000 !important;
                                                font-weight: 600;
                                                letter-spacing: 0.6px;
                                            '> " . $product->status->name . " </span>";
                                } elseif ($product->status_id == 3) {
                                    echo '<i style="font-size:1.5rem; color: #ff8300!important; margin: 5px;" class="fas fa-truck"></i> ';
                                    echo "<span style='color: #ff8300 !important;
                                                font-weight: 600;
                                                letter-spacing: 0.6px;
                                            '> " . $product->status->name . " </span>";
                                } elseif ($product->status_id == 4) {
                                    echo '<i style="font-size:1.5rem; color: #0331fc!important; margin: 5px;" class="fa fa-bars"></i> ';
                                    echo "<span style='color: #0331fc !important;
                                                font-weight: 600;
                                                letter-spacing: 0.6px;
                                            '> " . $product->status->name . " </span>";
                                } else {
                                    echo "<span style='color: #060505!important;
                                                font-weight: 600;
                                                letter-spacing: 0.6px;
                                            '> " . $product->status->name . " </span>";
                                }
                                ?>
                            </span>

                    </div>
                </div>
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

<?php
$js = <<<JS
$( document ).ready(function() {

      $('table').each(function() {
              $( this ).addClass( "table table-bordered" );
      });
});

JS;
$this->registerJs($js);
?>
