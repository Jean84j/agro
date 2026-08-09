<?php

use common\models\shop\ActivePages;

ActivePages::setActiveUser();

?>

<div class="cart-empty py-4 px-3 text-center position-relative">

    <button class="cart-view__close quickview__close position-absolute" type="button" aria-label="<?= Yii::t('app', 'Закрити') ?>" style="top: 15px; right: 15px;">
        <svg width="18px" height="18px">
            <use xlink:href="/images/sprite.svg#cross-20"></use>
        </svg>
    </button>

    <div class="cart-empty__content d-flex flex-column align-items-center">

        <div class="cart-empty__image mb-3">
            <img src="/images/empty-cart.png" alt="<?= Yii::t('app', 'Порожній кошик') ?>" style="max-width: 120px; height: auto;">
        </div>

        <h3 class="cart-empty__title font-weight-bold mb-2" style="font-size: 22px;">
            <?= Yii::t('app', 'Ваш кошик порожній') ?>
        </h3>

        <p class="cart-empty__message text-muted mb-4" style="font-size: 15px; max-width: 320px;">
            <?= Yii::t('app', 'Додайте товари до кошика, щоб вони з’явилися тут.') ?>
        </p>

        <div class="cart-empty__action">
            <a href="<?= Yii::$app->urlManager->createUrl(['category/list']) ?>" class="btn btn-primary btn-lg shadow_element" style="font-size: 16px;">
                <?= Yii::t('app', 'Перейти до каталогу') ?>
            </a>
        </div>

    </div>
</div>

