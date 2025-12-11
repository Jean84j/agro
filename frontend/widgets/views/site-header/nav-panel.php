<?php

use frontend\widgets\CategoryWidget;
use yii\helpers\Url;

/** @var $compareList */
/** @var $wishList */
/** @var $checkoutUrl */

?>
<div class="site-header__nav-panel">
    <!-- data-sticky-mode - one of [pullToShow, alwaysOnTop] -->
    <div class="nav-panel nav-panel--sticky" data-sticky-mode="pullToShow">
        <div class="nav-panel__container container">
            <div class="nav-panel__row">
                <div class="nav-panel__departments">
                    <?= CategoryWidget::widget() ?>
                </div>
                <div class="nav-panel__nav-links nav-links">
                    <ul class="nav-links__list">
                        <li class="nav-links__item  nav-links__item--has-submenu ">
                            <a class="nav-links__item-link" href="<?= Url::to(['special/view']) ?>">
                                <div class="nav-links__item-body header-menu">
                                    <?= Yii::t('app', 'Спеціальні пропозиції') ?>
                                </div>
                            </a>
                        </li>
                        <li class="nav-links__item  nav-links__item--has-submenu ">
                            <a class="nav-links__item-link" href="<?= Url::to(['delivery/view']) ?>">
                                <div class="nav-links__item-body header-menu">
                                    <?= Yii::t('app', 'Доставка') ?>
                                </div>
                            </a>
                        </li>
                        <li class="nav-links__item  nav-links__item--has-submenu ">
                            <a class="nav-links__item-link" href="<?= Url::to(['contact/view']) ?>">
                                <div class="nav-links__item-body header-menu">
                                    <?= Yii::t('app', 'Зв’язок з нами') ?>
                                </div>
                            </a>
                        </li>
                        <li class="nav-links__item  nav-links__item--has-submenu ">
                            <a class="nav-links__item-link" href="<?= Url::to(['blogs/view']) ?>">
                                <div class="nav-links__item-body header-menu">
                                    <?= Yii::t('app', 'Статті') ?>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="nav-panel__indicators">
                    <div class="indicator">
                        <a href="<?= Url::to(['wish/view']) ?>" data-toggle="tooltip" title="Бажання"
                           class="indicator__button">
                                            <span class="indicator__area">
                                                <svg width="20px" height="20px">
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
                                                <svg width="20px" height="20px">
                                                    <use xlink:href="/images/sprite.svg#compare-16"></use>
                                                </svg>
                                                    <span class="indicator__value"
                                                          id="compare-indicator"><?= $compareList ?></span>
                                            </span>
                        </a>
                    </div>
                    <?php if (!$checkoutUrl) : ?>
                        <div class="indicator indicator--trigger--click cart-header">
                            <a href="#" data-toggle="tooltip"
                               title="Корзина"
                               class="indicator__button"
                               data-url-cart-view-all="<?= Yii::$app->urlManager->createUrl(['cart/cart-view-all']) ?>">
                                    <span class="indicator__area">
                                        <svg width="24px" height="24px">
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