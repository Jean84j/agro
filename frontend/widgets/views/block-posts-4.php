<?php

use common\models\shop\ProductImage;
use yii\helpers\Url;

/** @var \common\models\Posts $posts */

$webp_support = ProductImage::imageWebp();

?>
<div class="block block-posts" data-layout="grid-4" data-mobile-columns="2">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title highlight-posts"><?= Yii::t('app', 'Статті') ?></h3>
            <div class="block-header__divider line-color-posts"></div>
            <div class="block-header__arrows-list">
                <button class="block-header__arrow block-header__arrow--left" type="button" aria-label="Left">
                    <svg width="7px" height="11px">
                        <use xlink:href="/images/sprite.svg#arrow-rounded-left-7x11"></use>
                    </svg>
                </button>
                <button class="block-header__arrow block-header__arrow--right" type="button" aria-label="Right">
                    <svg width="7px" height="11px">
                        <use xlink:href="/images/sprite.svg#arrow-rounded-right-7x11"></use>
                    </svg>
                </button>
            </div>
        </div>
        <div class="block-posts__slider">
            <div class="owl-carousel">
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <div class="post-card__image">
                            <a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>">
                                <?php if ($post->image != null): ?>
                                    <?php if (Yii::$app->devicedetect->isMobile()) { ?>
                                        <?php if ($webp_support == true && isset($post->webp_medium)) { ?>
                                            <img src="posts/<?= $post->webp_medium ?>" width="159" height="107"
                                                 alt="<?= $post->title ?>" loading="lazy">
                                        <?php } else { ?>
                                            <img src="posts/<?= $post->medium ?>" width="159" height="107"
                                                 alt="<?= $post->title ?>" loading="lazy">
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if ($webp_support == true && isset($post->webp_large)) { ?>
                                            <img src="posts/<?= $post->webp_large ?>" width="263" height="177"
                                                 alt="<?= $post->title ?>" loading="lazy">
                                        <?php } else { ?>
                                            <img src="posts/<?= $post->large ?>" width="263" height="177"
                                                 alt="<?= $post->title ?>" loading="lazy">
                                        <?php } ?>
                                    <?php } ?>
                                <?php endif ?>
                            </a>
                        </div>
                        <div class="post-card__info">
                            <div class="post-card__category">
                            </div>
                            <div class="post-card__name">
                                <a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>"><?= $post->title ?></a>
                            </div>
                            <div class="post-card__date"><?= Yii::$app->formatter->asDate($post->date_public) ?></div>
                            <div class="post-card__content">
                                <?= mb_substr($post->description, 0, 50) . (mb_strlen($post->description) > 50 ? '...' : '') ?>
                            </div>
                            <div class="post-card__read-more">
                                <a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>"
                                   class="btn btn-secondary btn-sm"><?= Yii::t('app', 'Докладніше...') ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<style>
    .highlight-posts {
        background-color: rgba(251, 121, 51, 0.8);
        padding: 5px;
        border-radius: 5px;
        border: 1px solid rgba(151, 86, 14, 0.8);
        display: inline-block;
    }
    .line-color-posts {
        background-color: rgba(251, 121, 51, 0.8);
    }
</style>