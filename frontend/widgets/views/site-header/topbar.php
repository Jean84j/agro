<?php

use yii\helpers\Url;

/** @var $path */
/** @var $lang */

?>
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
