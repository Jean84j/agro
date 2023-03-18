<?php

use frontend\widgets\CategoryWidget;
use yii\helpers\Url;

?>

<header class="site__header d-lg-block d-none">
        <div class="site-header">
            <!-- .topbar -->

        <!-- .topbar / end -->
        <div class="site-header__middle container">
            <div class="site-header__logo">
                <a href="/">
                    <!-- logo -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="196px" height="26px">
                        <img style="display: block;margin: -28px -12px 0px -28px; width: 237px; "
                             src="/frontend/web/images/logos/logoagro.png" alt="">
                    </svg>
                    <!-- logo / end -->
                </a>
            </div>
            <div class="site-header__search">
                <div class="search search--location--header ">
                    <div class="search__body">
                        <form class="search__form" action="">
                            <input class="search__input" name="search" placeholder="Пошук товарів"
                                   aria-label="Site search" type="text" autocomplete="off">
                            <button class="search__button search__button--type--submit" type="submit">
                                <svg width="20px" height="20px">
                                    <use xlink:href="/images/sprite.svg#search-20"></use>
                                </svg>
                            </button>
                            <div class="search__border"></div>
                        </form>
                        <div class="search__suggestions suggestions suggestions--location--header"></div>
                    </div>
                </div>
            </div>
            <div class="site-header__phone">
                <div class="site-header__phone-title">Номер для замовлення</div>
                <div class="site-header__phone-number">(050) ххх-20-76</div>
            </div>
        </div>
        <div class="site-header__nav-panel">
            <!-- data-sticky-mode - one of [pullToShow, alwaysOnTop] -->
            <div class="nav-panel nav-panel--sticky" data-sticky-mode="pullToShow">
                <div class="nav-panel__container container">
                    <div class="nav-panel__row">
                        <div class="nav-panel__departments">
                            <!-- .departments -->
                            <?= CategoryWidget::widget() ?>
                            <!-- .departments / end -->
                        </div>
                        <!-- .nav-links -->
                        <div class="nav-panel__nav-links nav-links">
                            <ul class="nav-links__list">
                                <li class="nav-links__item  nav-links__item--has-submenu ">
                                    <a class="nav-links__item-link" href="<?= Url::to(['/delivery/view']) ?>">
                                        <div class="nav-links__item-body">
                                            Доставка та оплата
                                        </div>
                                    </a>

                                </li>
                                <li class="nav-links__item  nav-links__item--has-submenu ">
                                    <a class="nav-links__item-link" href="#">
                                        <div class="nav-links__item-body">
                                            Спеціальні пропозиції
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-links__item  nav-links__item--has-submenu ">
                                    <a class="nav-links__item-link" href="<?= Url::to(['/about/view']) ?>">
                                        <div class="nav-links__item-body">
                                            Про нас
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-links__item  nav-links__item--has-submenu ">
                                    <a class="nav-links__item-link" href="<?= Url::to(['/contact/view']) ?>">
                                        <div class="nav-links__item-body">
                                            Зв'язок з нами
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-links__item  nav-links__item--has-submenu ">
                                    <a class="nav-links__item-link" href="#">
                                        <div class="nav-links__item-body">
                                            Статті
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <!-- .nav-links / end -->
                        <div class="nav-panel__indicators">

                            <div class="indicator indicator--trigger--click cart-header">
                                <a href="#" class="indicator__button ">
                                    <span class="indicator__area">
                                        <svg width="20px" height="20px">
                                            <use xlink:href="/images/sprite.svg#cart-20"></use>
                                        </svg>
                                        <span class="indicator__value" id="desc-qty-cart"><?= \Yii::$app->cart->getCount() ?></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>