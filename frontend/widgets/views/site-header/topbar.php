<?php

use yii\helpers\Url;

/** @var $path */
/** @var $lang */
/** @var $topBarLinks */

?>
<div class="site-header__topbar topbar">
    <div class="topbar__container container">
        <div class="topbar__row">
            <?php foreach ($topBarLinks as $topBarLink): ?>
                <div class="topbar__item topbar__item--link">
                    <a class="topbar-link"
                       href="<?= Url::to([$topBarLink['url']]) ?>"><?= Yii::t('app', $topBarLink['name']) ?></a>
                </div>
            <?php endforeach; ?>
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

            <?php if (YII_ENV_DEV): ?>
                <?php
                $status = '';
                $color = '';

                if (Yii::$app->user->isGuest) {
                    $status = '🥶 Гість';
                    $color = 'cornflowerblue';
                } else {
                    if (Yii::$app->user->identity->role === 1) {
                        $status = '😉 Користувач';
                        $color = '#37b937';
                    }
                    if (Yii::$app->user->identity->role === 2) {
                        $status = '🦝 Менеджер';
                        $color = 'crimson';
                    }
                    if (Yii::$app->user->identity->role === 3) {
                        $status = '🤖 Адміністратор';
                        $color = 'crimson';
                    }
                }
                ?>
                <div class="topbar__item">
                    <div class="topbar-dropdown">
                        <button class="topbar-dropdown__btn" type="button" style="background-color: <?= $color ?>">
                            <span style="color: white; font-weight: bold">
                            <?= $status ?>
                            </span>

                        </button>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
