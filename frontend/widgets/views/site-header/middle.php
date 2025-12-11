<?php

/** @var $contacts */

?>
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