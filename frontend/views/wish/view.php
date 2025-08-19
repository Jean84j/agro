<?php

use common\models\shop\ActivePages;
use frontend\assets\WishListPageAsset;
use frontend\widgets\ProductsCarousel;
use frontend\widgets\ViewProduct;
use yii\helpers\Url;

ActivePages::setActiveUser();
WishListPageAsset::register($this);

?>
    <div class="site__body">
        <div class="page-header">
            <div class="page-header__container container">
                <div class="page-header__breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/"> <i class="fas fa-home"></i> <?=Yii::t('app','Головна')?></a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?=Yii::t('app','Список бажань')?></li>
                        </ol>
                    </nav>
                </div>
                <div class="page-header__title">
                    <h1><?=Yii::t('app','Список бажань')?></h1>
                </div>
            </div>
        </div>
        <div id="wish-list">
            <?php if ($products) { ?>
                <div class="block">
                    <div class="container">
                        <table class="wishlist">
                            <thead class="wishlist__head">
                            <tr class="wishlist__row">
                                <th class="wishlist__column wishlist__column--image"><?=Yii::t('app','Зображення')?></th>
                                <th class="wishlist__column wishlist__column--product"><?=Yii::t('app','Назва')?></th>
                                <th class="wishlist__column wishlist__column--stock"><?=Yii::t('app','Наявність')?></th>
                                <th class="wishlist__column wishlist__column--price"><?=Yii::t('app','Ціна')?></th>
                                <th class="wishlist__column wishlist__column--tocart"></th>
                                <th class="wishlist__column wishlist__column--remove"></th>
                            </tr>
                            </thead>
                            <tbody class="wishlist__body">
                            <?php foreach ($products as $product): ?>
                                <tr class="wishlist__row">
                                    <td class="wishlist__column wishlist__column--image">
                                        <div class="product-image">
                                            <a class="product-image__body"
                                               href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>">
                                                <img class="product-image__img"
                                                     src="<?= $product->getImgOneLarge($product->getId()) ?>"
                                                     width="80" height="80"
                                                     alt="<?= $product->name ?>">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="wishlist__column wishlist__column--product">
                                        <?php if ($product->category->prefix) { ?>
                                            <div class="product-card__name">
                                                <?php echo $product->category->prefix ? '<span class="category-prefix">' . $product->category->prefix . '</span>' : '' ?>
                                            </div>
                                        <?php } ?>
                                        <div class="product-card__name">
                                            <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $product->name ?></a>
                                        </div>
                                        <div class="wishlist__product-rating">
                                            <div class="rating">
                                                <?= $product->getRating($product->id, 13, 12) ?>
                                            </div>
                                            <div class="wishlist__product-rating-legend"><?= count($product->reviews) ?>
                                                <?=Yii::t('app','відгуків')?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="wishlist__column wishlist__column--stock">
                                        <div class="product__availability" style="text-align: center; font-size: 1rem; font-weight: 600; letter-spacing: 0.6px;">

                                            <?php $statusIcon = '';
                                            $statusStyle = '';

                                            switch ($product->status_id) {
                                                case 1:
                                                    $statusIcon = '<i style="margin: 5px; color: #28a745;" class="fas fa-check"></i>';
                                                    $statusStyle = 'color: #28a745;';
                                                    break;
                                                case 2:
                                                    $statusIcon = '<i style="margin: 5px; color: #ff0000;" class="fas fa-ban"></i>';
                                                    $statusStyle = 'color: #ff0000;';
                                                    break;
                                                case 3:
                                                    $statusIcon = '<i style="margin: 5px; color: #ff8300;" class="fas fa-truck"></i>';
                                                    $statusStyle = 'color: #ff8300;';
                                                    break;
                                                case 4:
                                                    $statusIcon = '<i style="margin: 5px; color: #0331fc;" class="fa fa-bars"></i>';
                                                    $statusStyle = 'color: #0331fc;';
                                                    break;
                                                default:
                                                    $statusStyle = 'color: #060505;';
                                                    break;
                                            }

                                            echo $statusIcon . '<span style="' . $statusStyle . '">' . Yii::t('app', $product->status->name) . '</span>';
                                            ?>

                                        </div>
                                    </td>
                                    <td class="wishlist__column wishlist__column--price">
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
                                    </td>
                                    <td class="wishlist__column wishlist__column--tocart">
                                        <?php if ($product->status_id != 2) { ?>
                                            <button class="btn btn-primary btn-sm product-card__addtocart"
                                                    type="button"
                                                    data-product-id="<?= $product->id ?>"
                                                    data-url-cart-view="<?= Yii::$app->urlManager->createUrl(['cart/cart-view']) ?>"
                                                    data-url-qty-cart="<?= Yii::$app->urlManager->createUrl(['cart/qty-cart']) ?>"
                                            >
                                                <svg width="20px" height="20px" style="display: unset;">
                                                    <use xlink:href="/images/sprite.svg#cart-20"></use>
                                                </svg>
                                                <?= !$product->getIssetToCart($product->id) ? Yii::t('app','Купити') : Yii::t('app','В кошику') ?>
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-secondary btn-sm disabled"
                                                    type="button"
                                                    data-product-id="<?= $product->id ?>">
                                                <svg width="20px" height="20px" style="display: unset;">
                                                    <use xlink:href="/images/sprite.svg#cart-20"></use>
                                                </svg>
                                                <?= !$product->getIssetToCart($product->id) ? Yii::t('app','Купити') : Yii::t('app','В кошику') ?>
                                            </button>
                                        <?php } ?>
                                    </td>
                                    <td class="wishlist__column wishlist__column--remove">
                                        <button type="button"
                                                class="btn btn-light btn-sm btn-svg-icon"
                                                id="delete-from-wish-btn"
                                                data-url-wish="<?= Yii::$app->urlManager->createUrl(['wish/delete-from-wish']) ?>"
                                                data-wish-product-id="<?= $product->id ?>">
                                            <svg width="12px" height="12px">
                                                <use xlink:href="/images/sprite.svg#cross-12"></use>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <div class="block">
                    <div class="container">
                        <div class="wishlist-not-products">
                            <div class="wishlist-not-products__content">
                                <h2 class="wishlist-not-products__title"><?=Yii::t('app','Список бажань порожній!')?></h2>
                                <p class="wishlist-not-products__text">
                                    <?=Yii::t('app','Додайте товари до списку бажань.')?>
                                    <br>
                                    <?=Yii::t('app','Спробуйте скористатися пошуком.')?>
                                </p>
                                <img src="/images/no-wish.jpg" alt="Список бажань порожній">
                                <p class="wishlist-not-products__text">
                                    <?=Yii::t('app','Або перейдіть на головну сторінку, щоб почати все спочатку.')?>
                                </p>
                                <a class="btn btn-secondary btn-sm" href="/"><?=Yii::t('app','На Головну Сторінку')?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="container spec__disclaimer">
            <?= $page_description ?>
        </div>
        <?php echo ProductsCarousel::widget() ?>
        <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
    </div>
    <style>
        .wishlist-not-products {
            text-align: center;
        }
        .wishlist-not-products__content {
            width: 480px;
            max-width: 100%;
            margin: 0 auto;
        }
        .wishlist-not-products__title{
            margin-bottom: 30px;
        }
        .wishlist-not-products__text{
            margin-bottom: 20px;
        }
    </style>
<?php
$script = <<< JS
    $(document).on('click', '#delete-from-wish-btn', function(e) {
    e.preventDefault();
    var wishIndicator = $('#wish-indicator');
    var wishListContainer = $('#wish-list');
    var productId = $(this).data('wish-product-id');
    var url = $(this).data('url-wish');
    $.ajax({
        url: url,
        type: 'POST',
        data: { id: productId },
        success: function(response) {
    if (response.success) {
        wishListContainer.html(response.wishListHtml);
        wishIndicator.text(response.wishCount);
    } else {
        console.log('Произошла ошибка при удалении товара из списка сравнения')
    }
},
        error: function() {
            console.log('Произошла ошибка при выполнении AJAX-запроса')
        }
    });
});
JS;
$this->registerJs($script);
?>