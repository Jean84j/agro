<?php

use yii\helpers\Url;

/** @var $checkoutUrl */

$session = Yii::$app->session;
$compareList = $session->get('compareList', []);
$compareList = count($compareList);

$wishList = $session->get('wishList', []);
$wishList = count($wishList);

?>
<header class="site__header d-lg-none">
    <div class="mobile-header mobile-header--sticky" data-sticky-mode="pullToShow">
        <div class="mobile-header__panel">
            <div class="container">
                <div class="mobile-header__body">
                    <button class="mobile-header__menu-button" aria-label="Menu">
                        <svg width="18px" height="14px">
                            <use xlink:href="/images/sprite.svg#menu-18x14"></use>
                        </svg>
                    </button>
                    <a class="mobile-header__logo" href="/" aria-label="AgroPro — на головну">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120px" height="40px">
                            <text fill="#fff" stroke="#000" stroke-width="0" x="0" y="33" font-size="30"
                                  font-family="Urbanist" text-anchor="start" font-weight="bold">
                                AgroPro
                            </text>
                        </svg>
                    </a>
                    <div class="search search--location--mobile-header mobile-header__search">
                        <div class="search__body">
                            <form class="search__form"
                                  data-url="<?= Yii::$app->urlManager->createUrl(['search/suggestions-ajax']) ?>"
                                  action="<?= Yii::$app->urlManager->createUrl(['search/suggestions']) ?>">
                                <input class="search__input" name="q" placeholder="Пошук товарів"
                                       aria-label="Site search" type="text" autocomplete="off">
                                <button class="search__button search__button--type--submit" type="submit"
                                        aria-label="Site search">
                                    <svg width="20px" height="20px">
                                        <use xlink:href="/images/sprite.svg#search-20"></use>
                                    </svg>
                                </button>
                                <button class="search__button search__button--type--close" type="button"
                                        aria-label="Site search">
                                    <svg width="20px" height="20px">
                                        <use xlink:href="/images/sprite.svg#cross-20"></use>
                                    </svg>
                                </button>
                                <div class="search__border"></div>
                            </form>
                            <div class="search__suggestions suggestions suggestions--location--mobile-header"></div>
                        </div>
                    </div>
                    <div class="nav-panel__indicators">
                        <div class="indicator indicator--mobile-search indicator--mobile d-md-none">
                            <button class="indicator__button" aria-label="Site search">
                                        <span class="indicator__area">
                                            <svg width="20px" height="20px">
                                                <use xlink:href="/images/sprite.svg#search-20"></use>
                                            </svg>
                                        </span>
                            </button>
                        </div>
                        <div class="indicator">
                            <a href="<?= Url::to(['wish/view']) ?>" data-toggle="tooltip" title="Бажання"
                               class="indicator__button">
                                            <span class="indicator__area">
                                                <svg width="16px" height="16px">
                                                    <use xlink:href="/images/sprite.svg#wishlist-16"></use>
                                                </svg>
                                                    <span class="indicator__value"
                                                          id="wish-indicator"><?= $wishList ?></span>
                                            </span>
                            </a>
                        </div>
                        <div class="indicator">
                            <a href="<?= Url::to(['compare/view']) ?>" data-toggle="tooltip" title="Порівняння"
                               class="indicator__button">
                                            <span class="indicator__area">
                                                <svg width="16px" height="16px">
                                                    <use xlink:href="/images/sprite.svg#compare-16"></use>
                                                </svg>
                                                    <span class="indicator__value"
                                                          id="compare-indicator"><?= $compareList ?></span>
                                            </span>
                            </a>
                        </div>
                        <?php if (!$checkoutUrl) : ?>
                            <div class="indicator indicator--trigger--click cart-header">
                                <a href="#" class="indicator__button"
                                   data-url-cart-view-all="<?= Yii::$app->urlManager->createUrl(['cart/cart-view-all']) ?>"
                                >
                                    <span class="indicator__area">
                                        <svg width="20px" height="20px">
                                            <use xlink:href="/images/sprite.svg#cart-20"></use>
                                        </svg>
                                        <span class="indicator__value"
                                              id="desc-qty-cart"><?= Yii::$app->cart->getCount() ?></span>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>