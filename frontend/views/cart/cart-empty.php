<?php

use common\models\shop\ActivePages;

ActivePages::setActiveUser();

?>

<div class="cart-empty">

    <button class="cart-view__close quickview__close" type="button" aria-label="<?= Yii::t('app', 'Закрити') ?>">
        <svg width="20px" height="20px">
            <use xlink:href="/images/sprite.svg#cross-20"></use>
        </svg>
    </button>
    <div class="cart-empty__content">
        <div class="page-header">
            <div class="container">
                <h1 class="page-header__title" style="font-size: 28px; text-align: center; margin-top: 42px;">
                    <?= Yii::t('app', 'Ваш кошик порожній') ?>
                </h1>
            </div>
        </div>
        <div class="cart-empty__message" style="text-align: center; margin: 30px 0;">
            <p style="font-size: 18px; color: #666;">
                <?= Yii::t('app', 'Додайте товари до кошика, щоб вони з’явилися тут.') ?>
            </p>
        </div>
        <div class="cart-empty__action" style="text-align: center; margin-top: 20px;">
            <a href="<?= Yii::$app->urlManager->createUrl(['category/list']) ?>" class="btn btn-primary btn-lg" style="padding: 14px 20px; font-size: 18px;">
                <?= Yii::t('app', 'Перейти до каталогу') ?>
            </a>
        </div>
        <div class="cart-empty__image" style="text-align: center; margin-top: 30px; margin-bottom: 10px">
            <img src="/images/empty-cart.png" alt="<?= Yii::t('app', 'Порожній кошик') ?>" style="max-width: 100%; height: auto;">
        </div>
    </div>
</div>

