<?php

use frontend\widgets\CategoryWidget;
use yii\helpers\Url;

$checkoutUrl = str_contains(Yii::$app->request->url, 'checkout');

?>

<?php if ($isMobile): ?>
    <?= $this->render('@frontend/views/layouts/mobile-site-header.php') ?>
    <?= $this->render('@frontend/views/layouts/mobilemenu.php', ['categories' => $categories, 'contacts' => $contacts, 'path' => $path, 'lang' => $lang]) ?>
<?php else: ?>
    <header class="site__header d-lg-block d-none">
        <div class="site-header">
            <div class="site-header__topbar topbar">
                <div class="topbar__container container">
                    <div class="topbar__row">
                        <div class="topbar__item topbar__item--link">
                            <a class="topbar-link"
                               href="<?= Url::to(['about/view']) ?>"><?= Yii::t('app', 'Про нас') ?></a>
                        </div>
                        <div class="topbar__item topbar__item--link">
                            <a class="topbar-link"
                               href="<?= Url::to(['contact/view']) ?>"><?= Yii::t('app', 'Контакти') ?></a>
                        </div>
                        <div class="topbar__item topbar__item--link">
                            <a class="topbar-link"
                               href="<?= Url::to(['delivery/view']) ?>"><?= Yii::t('app', 'Доставка Оплата') ?></a>
                        </div>
                        <div class="topbar__item topbar__item--link">
                            <a class="topbar-link"
                               href="<?= Url::to(['tag/index']) ?>"><?= Yii::t('app', 'Теги') ?></a>
                        </div>
                        <div class="topbar__item topbar__item--link">
                            <a class="topbar-link"
                               href="<?= Url::to(['brands/view']) ?>"><?= Yii::t('app', 'Бренди') ?></a>
                        </div>
                        <div class="topbar__item topbar__item--link">
                            <a class="topbar-link"
                               href="<?= Url::to(['blogs/view']) ?>"><?= Yii::t('app', 'Статті') ?></a>
                        </div>
                        <div class="topbar__spring"></div>
                        <div class="topbar__item">
                            <div class="topbar-dropdown">
                                <button class="topbar-dropdown__btn" type="button">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= Yii::t('app', 'Полтава') ?>
                                    <svg width="7px" height="5px">
                                        <use xlink:href="/images/sprite.svg#arrow-rounded-down-7x5"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="topbar__item">
                            <div class="topbar-dropdown">
                                <button class="topbar-dropdown__btn" type="button">
                                    <?= Yii::t('app', 'Валюта') ?>: <span class="topbar__item-value">UAH</span>
                                    <svg width="7px" height="5px">
                                        <use xlink:href="/images/sprite.svg#arrow-rounded-down-7x5"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="topbar__item">
                            <div class="topbar-dropdown">
                                <button class="topbar-dropdown__btn" type="button">
                                    <?php echo Yii::t('app', 'Мова') ?>:
                                    <span class="topbar__item-value"><?php echo $lang ?></span>
                                    <svg width="7px" height="5px">
                                        <use xlink:href="/images/sprite.svg#arrow-rounded-down-7x5"></use>
                                    </svg>
                                </button>
                                <div class="topbar-dropdown__body">
                                    <div class="menu menu--layout--topbar  menu--with-icons ">
                                        <div class="menu__submenus-container"></div>
                                        <ul class="menu__list">
                                            <li class="menu__item">
                                                <div class="menu__item-submenu-offset"></div>
                                                <a class="menu__item-link"
                                                   href="<?php echo Url::to(['/' . $path, 'language' => 'uk']) ?>">
                                                    <div class="menu__item-icon">
                                                        <img src="/images/languages/language-UK.png" width="20"
                                                             height="16" alt="UK">
                                                    </div>
                                                    Українська
                                                </a>
                                            </li>
                                            <li class="menu__item">
                                                <div class="menu__item-submenu-offset"></div>
                                                <a class="menu__item-link"
                                                   href="<?php echo Url::to(['/' . $path, 'language' => 'ru']) ?>">
                                                    <div class="menu__item-icon">
                                                        <img src="/images/languages/language-RU.png" width="20"
                                                             height="16" alt="RU">
                                                    </div>
                                                    Русский
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="topbar__item">
                            <div class="topbar-dropdown">
                                <button class="topbar-dropdown__btn" type="button">
                                    <?php if ($lang == 'UK') { ?>
                                        <img src="/images/languages/language-UK.png" width="20" height="16" alt="UK">
                                    <?php } else { ?>
                                        <img src="/images/languages/language-RU.png" width="20" height="16" alt="RU">
                                    <?php } ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-header__middle container">
                <div class="site-header__logo">
                    <a href="/" aria-label="AgroPro — на головну">
                        <svg width="290" height="79" xmlns="http://www.w3.org/2000/svg">
                            <text fill="#47991f" stroke="#000" stroke-width="0" x="81.79" y="52.16" font-size="40"
                                  font-family="Urbanist" text-anchor="start" font-weight="bold"
                                  transform="matrix(1.64322 0 0 1.20007 -123.343 -5.40369)">AgroPro
                            </text>
                            <line x1="10" y1="19" x2="25" y2="19" stroke="#6c757d" stroke-width="3"/>
                            <line x1="45" y1="19" x2="165" y2="19" stroke="#007bff" stroke-width="5" opacity="0.4"/>
                            <line x1="208" y1="19" x2="275" y2="19" stroke="#6c757d" stroke-width="3"/>
                            <line x1="10" y1="65" x2="59" y2="65" stroke="#6c757d" stroke-width="3"/>
                            <line x1="100" y1="65" x2="275" y2="65" stroke="#ffc107" stroke-width="5" opacity="0.4"/>
                        </svg>
                    </a>
                </div>
                <div class="site-header__search">
                    <div class="search search--location--header ">
                        <div class="search__body">
                            <form class="search__form"
                                  data-url="<?= Yii::$app->urlManager->createUrl(['search/suggestions-ajax']) ?>"
                                  action="<?= Yii::$app->urlManager->createUrl(['search/suggestions']) ?>">
                                <input class="search__input" name="q"
                                       placeholder="<?= Yii::t('app', 'Пошук товарів') ?>"
                                       aria-label="Site search" type="text" autocomplete="off">
                                <button class="search__button search__button--type--submit" type="submit"
                                        aria-label="Site search">
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
                    <div class="site-header__phone-title"><?= Yii::t('app', 'Номер для замовлення') ?></div>
                    <div class="site-header__phone-number"
                         style="margin: 0px 0px 6px 0px;"><i class="fas fa-mobile-alt"></i> <a
                                href="tel:<?= str_replace([' ', '(', ')', '-'], '', $contacts->tel_primary) ?>"><?= $contacts->tel_primary ?></a>
                    </div>
                    <div class="site-header__phone-number"><i
                                class="fas fa-mobile-alt"></i> <a
                                href="tel:<?= str_replace([' ', '(', ')', '-'], '', $contacts->tel_second) ?>"><?= $contacts->tel_second ?></a>
                    </div>
                </div>
            </div>
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
        </div>
    </header>
<?php endif; ?>