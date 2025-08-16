<?php

use yii\helpers\Url;

/** @var \common\models\Slider $slides */

?>
<div class="block-slideshow block-slideshow--layout--with-departments block">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 d-none d-lg-block"></div>
            <div class="col-12 col-lg-9">
                <div class="block-slideshow__body">
                    <div class="owl-carousel">
                        <?php foreach ($slides as $slide): ?>
                            <div class="block-slideshow__slide">
                                <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop"
                                     style="background-image: url('/images/slider/<?= $slide->image ?>')"></div>
                                <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile"
                                     style="background-image: url('/images/slider/<?= $slide->image_mob ?>')"></div>
                                <div class="block-slideshow__slide-content">
                                    <div class="block-slideshow__slide-title slideshow__shadow"><?php echo $slide->title ?></div>
                                    <?php if (Yii::$app->devicedetect->isMobile()) { ?>
                                        <div class="col-10 block-slideshow__slide-text"
                                             style="margin: 25px 0px 0px 70px;"><?php echo $slide->description ?></div>
                                    <?php } else { ?>
                                        <div class="col-10 block-slideshow__slide-text"
                                             style="margin: 0px 0px 0px -40px;"><?php echo $slide->description ?></div>
                                    <?php } ?>
                                    <?php if ($slide->getSliderOldPrice($slide->slug) == null) { ?>
                                        <div class="block-slideshow__slide-text product-card__prices"><?php echo Yii::$app->formatter->asCurrency($slide->getSliderPrice($slide->slug)) ?></div>
                                    <?php } else { ?>
                                        <div class="block-slideshow__slide-text product-card__prices">
                                            <span class="product-card__new-price"><?php echo Yii::$app->formatter->asCurrency($slide->getSliderPrice($slide->slug)) ?></span>
                                            <span class="product-card__old-price"><?php echo Yii::$app->formatter->asCurrency($slide->getSliderOldPrice($slide->slug)) ?></span>
                                        </div>
                                    <?php } ?>
                                    <a href="<?= Url::to(['/product/' . $slide->slug]) ?>">
                                        <div class="block-slideshow__slide-button">
                                            <span class="btn btn-primary btn-lg"><?= Yii::t('app', 'Переглянути') ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .slideshow__shadow {
        text-shadow: 0 0 5px #fff,
        0 0 10px #fff,
        0 0 20px #fff,
        0 0 40px #fff;
    }
</style>