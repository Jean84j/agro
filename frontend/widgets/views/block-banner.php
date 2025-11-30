<?php

use yii\helpers\Url;

?>
<div class="block block-banner" style="margin: 0px 0px 20px 0px;">
    <div class="container">
        <a href="<?= Url::to(['catalog/zasobi-zahistu-roslin']) ?>" class="block-banner__body">
            <div class="block-banner__image block-banner__image--desktop" style="margin: 0px 0px 0px 0px; background-image: url('images/banners/banner-1.jpg')"></div>
            <div class="block-banner__image block-banner__image--mobile" style="background-image: url('images/banners/banner-1-mobile.jpg')"></div>
            <div class="block-banner__title"> Засоби <br class="block-banner__mobile-br"> Захисту Рослин </div>
            <div class="block-banner__text"> Гербіциди, Фунгіциди, Інсектициди, Протруйники, Прилипачі, Ад'юванти, Десиканти </div>
            <div class="block-banner__button">
                <span class="btn btn-sm btn-primary"> <?= Yii::t('app', 'Переглянути') ?> </span>
            </div>
        </a>
    </div>
</div>
