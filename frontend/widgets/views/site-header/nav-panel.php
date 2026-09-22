<?php

use frontend\widgets\CategoryWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $compareList */
/** @var $wishList */
/** @var $navLinks */

$visibleWishIndicator = 'display: none';
$visibleCompareIndicator = 'display: none';

if ($wishList !== 0){
    $visibleWishIndicator = '';
}
if ($compareList !== 0){
    $visibleCompareIndicator = '';
}

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
                        <?php foreach ($navLinks as $navLink): ?>
                            <li class="nav-links__item  nav-links__item--has-submenu ">
                                <a class="nav-links__item-link" href="<?= Url::to([$navLink['url']]) ?>">
                                    <div class="nav-links__item-body header-menu">
                                        <?= Yii::t('app', $navLink['name']) ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="nav-panel__indicators">

                    <div class="indicator" id="visibleWishIndicator" style="<?= $visibleWishIndicator ?>">
                        <a href="<?= Url::to(['/wish']) ?>" data-toggle="tooltip" title="Бажання"
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


                    <div class="indicator" id="visibleCompareIndicator" style="<?= $visibleCompareIndicator ?>">
                        <a href="<?= Url::to(['/compare']) ?>" data-toggle="tooltip" title="Порівняння"
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





                    <div class="indicator indicator--trigger--click">
                        <a href="#" class="indicator__button">
                                            <span class="indicator__area">
                                                <svg width="20px" height="20px">
                                                    <use xlink:href="/images/sprite.svg#person-20"></use>
                                                </svg>
                                            </span>
                        </a>
                        <div class="indicator__dropdown">
                            <div class="account-menu">
                                <?php if (!isset(Yii::$app->user->identity->username)): ?>
                                    <form class="account-menu__form" id="login-form" method="post" action="<?= Url::to(['site/login']) ?>">

                                        <div class="account-menu__form-title">
                                            Войдите в свою учетную запись
                                        </div>

                                        <?= Html::hiddenInput(
                                            Yii::$app->request->csrfParam,
                                            Yii::$app->request->getCsrfToken()
                                        ) ?>

                                        <div class="form-group">
                                            <label for="login-username" class="sr-only">Имя</label>

                                            <?= Html::textInput(
                                                'LoginForm[username]',
                                                '',
                                                [
                                                    'id' => 'login-username',
                                                    'class' => 'form-control form-control-sm',
                                                    'placeholder' => 'Имя',
                                                    'autocomplete' => 'username',
                                                ]
                                            ) ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="login-password" class="sr-only">Пароль</label>

                                            <div class="account-menu__form-forgot">

                                                <?= Html::passwordInput(
                                                    'LoginForm[password]',
                                                    '',
                                                    [
                                                        'id' => 'login-password',
                                                        'class' => 'form-control form-control-sm',
                                                        'placeholder' => 'Пароль',
                                                        'autocomplete' => 'current-password',
                                                    ]
                                                ) ?>

                                                <a href="<?= Url::to(['site/request-password-reset']) ?>"
                                                   class="account-menu__form-forgot-link">
                                                    Забыл?
                                                </a>

                                            </div>
                                        </div>

                                        <div class="form-group account-menu__form-button">
                                            <?= Html::submitButton(
                                                'Войти',
                                                [
                                                    'class' => 'btn btn-primary',
                                                    'name' => 'login-button',
                                                ]
                                            ) ?>
                                        </div>

                                        <div class="account-menu__form-link">
                                            <a href="<?= Url::to(['site/signup']) ?>">
                                                Завести аккаунт
                                            </a>
                                        </div>

                                    </form>



                                <?php else: ?>

                                <div class="account-menu__divider"></div>
                                <a href="<?= Url::to(['account/dashboard']) ?>" class="account-menu__user">
                                    <div class="account-menu__user-avatar">
                                        <img src="/images/avatars/<?= $avatar ?>.jpg"
                                             width="40" height="40"
                                             alt="<?= $avatar ?>"
                                             loading="lazy">
                                    </div>
                                    <div class="account-menu__user-info">
                                        <div class="account-menu__user-name"><?= Yii::$app->user->identity->username ?></div>
                                        <div class="account-menu__user-email"><?= Yii::$app->user->identity->email ?></div>
                                    </div>
                                </a>
                                <div class="account-menu__divider"></div>

<!--                                <ul class="account-menu__links">-->
<!--                                    <li><a href="--><?php //= Url::to(['account/view', 'card' => 'edit-profile']) ?><!--">Edit Profile</a></li>-->
<!--                                    <li><a href="--><?php //= Url::to(['account/view', 'card' => 'orders']) ?><!--">Історія замовлень</a></li>-->
<!--                                    <li><a href="--><?php //= Url::to(['account/view', 'card' => 'password']) ?><!--">Password</a></li>-->
<!--                                </ul>-->

                                <div class="account-menu__divider"></div>
                                <ul class="account-menu__links">
                                    <li><?= Html::a('Вихід', ['site/logout'], [
                                            'class' => 'dropdown-item',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                        ]) ?></li>
                                </ul>


                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>