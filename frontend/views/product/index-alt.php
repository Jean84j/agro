<?php
/** @var yii\web\View $this */
/** @var \common\models\shop\Product $product */
/** @var \common\models\shop\Product $products */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\RelatedProducts;

//debug($product->images);

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
                                    <a href="#">Home</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="">Breadcrumb</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Brandix Screwdriver SCREW1500ACC</li>
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
                                                        <a href="<?= '/product/' . $image->name ?>" data-width="700" data-height="700" class="product-image__body" target="_blank">
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
                                                    <a href="/images/products/product-16-4.jpg" class="product-image product-gallery__carousel-item">
                                                        <div class="product-image__body">
                                                            <img class="product-image__img product-gallery__carousel-image" src="<?= '/product/' . $image->name ?>" alt="<?= $image->name ?>">
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
                                                    <a href="/product/no-image.png" data-width="700" data-height="700" class="product-image__body" target="_blank">
                                                        <img class="product-image__img" src="/product/no-image.png" alt="no image">
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
                                        <li class="payment-methods__item" style="background: #ffe484;padding: 10px;color: black;">
                                            Артикул: <span style="margin-right: 10px;" id="sku">454545 </span>
                                        </li>
                                        <li class="payment-methods__item payment-methods__item--active">
                                            <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method" value="" type="radio" checked="">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                                                <span class="delivery-methods__item-title"><i style="font-size: 28px" class="fas fa-truck"></i>
                                            <span style="font-size:20px; margin:0px 20px">Доставка</span></span>
                                            </label>
                                            <div class="payment-methods__item-container" style="">
                                                <div class="payment-methods__item-description text-muted">

                                                </div>
                                            </div>
                                        </li>
                                        <li class="payment-methods__item">
                                            <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method" value="beznal" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                                                <span class="payment-methods__item-title"><i style="font-size: 28px" class="fas fa-credit-card"></i> <span style="font-size:20px; margin:0px 20px">Спосіб сплати</span></span>
                                            </label>
                                            <div class="payment-methods__item-container" style="">
                                                <div class="payment-methods__item-description text-muted">
                                                    <ul>
                                                        <li>Сплатити Visa/Mastercard</li>
                                                        <li>Оплатити готівкою</li>
                                                        <li>Наеладенний платіж</li>
                                                        <li>Сплатити на розрахунковий рахунок</li>
                                                        <hr>
                                                        <ul class="list-unstyled pay-methods">

                                                            <li title="Visa Checkout">
                                                                <img src="https://m.wayforpay.com/img/method2/visaCheckout.png" style="width: 65px; float: left; margin: 2px;">
                                                            </li>
                                                            <li title="Masterpass">
                                                                <img src="https://m.wayforpay.com/img/method2/masterPass.png" style="width: 65px; float: left; margin: 2px;">
                                                            </li>
                                                            <li title="Google Pay">
                                                                <img src="https://m.wayforpay.com/img/method2/googlePay.png" style="width: 65px; float: left; margin: 2px;">
                                                            </li>
                                                            <li title="Apple Pay">
                                                                <img src="https://m.wayforpay.com/img/method2/applePay.png" style="width: 65px; float: left; margin: 2px;">
                                                            </li>

                                                        </ul>

                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="payment-methods__item">
                                            <label class="payment-methods__item-header">
                                        <span class="payment-methods__item-radio input-radio">
                                            <span class="input-radio__body">
                                                <input class="input-radio__input" name="checkout_payment_method" value="online" type="radio">
                                                <span class="input-radio__circle"></span>
                                            </span>
                                        </span>
                                                <span class="shield-methods__item-title"><i style="font-size: 28px" class="fas fa-shield-alt"></i> <span style="font-size:20px; margin:0px 20px">Гарантия</span></span>
                                            </label>
                                            <div class="payment-methods__item-container" style="">
                                                <div class="payment-methods__item-description text-muted">
                                                    Гарантія на повернення ознайомтесь будь ласка з<a href="/company/vozvrat-i-garantii.html" target="_blank">правилами</a>
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
                                    <?= $product->price?> &#8372;
                                    <!-- <div class="product__actions-item product__actions-item--addtocart"> -->
                                    <?= Html::a(
                                        '<svg width="20px" height="20px" style="display: unset;margin: 0px 7px 0px -12px;">
                                            <use xlink:href="/images/sprite.svg#cart-20"></use>
                                        </svg>
                                        Купити',
                                        Url::to(['/cart/add-product', 'id' => $product->id]),
                                        [
                                            'class' => 'btn btn-primary',
                                            'role' => 'modal-remote-product',
                                            'data-toggle' => 'tooltip',
                                            'style' => "margin-top: -5px; margin-left: 12px; padding: 6px 35px;"
                                        ]
                                    )
                                    ?>
                                


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- .block-products-carousel -->

            <!-- .block-products-carousel / end -->
        </div>
        <!-- site__body / end -->