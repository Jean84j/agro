<?php

use frontend\widgets\ProductsCarousel;
use common\models\shop\ProductImage;
use common\models\shop\ActivePages;
use frontend\assets\BlogsPageAsset;
use frontend\widgets\TagCloud;
use common\models\Posts;
use yii\helpers\Url;

BlogsPageAsset::register($this);
ActivePages::setActiveUser();

/** @var Posts $pages */
/** @var Posts $blogs */
/** @var Posts $page_description */

$webp_support = ProductImage::imageWebp();

?>
<div class="site__body">
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/"> <i class="fas fa-home"></i> <?=Yii::t('app','Головна')?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?=Yii::t('app','Статті')?></li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1><?=Yii::t('app','Статті та поради')?></h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="block">
                    <div class="posts-view">
                        <div class="posts-view__list posts-list posts-list--layout--list">
                            <div class="posts-list__body">
                                <?php foreach ($blogs as $post): ?>
                                    <div class="container posts-list__item">
                                        <div class="post-card post-card--layout--list post-card--size--nl">
                                            <div class="post-card__image">
                                                <a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>">
                                                    <?php if ($webp_support == true && isset($post->webp_extra_large)) { ?>
                                                        <img src="/posts/<?= $post->webp_extra_large ?>"
                                                             width="350" height="235"
                                                             alt="<?= $post->title ?>">
                                                    <?php } else { ?>
                                                        <img src="/posts/<?= $post->extra_large ?>"
                                                             width="350" height="235"
                                                             alt="<?= $post->title ?>">
                                                    <?php } ?>
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
                                                    <?= strip_tags($post->description) ?>
                                                </div>
                                                <div class="post-card__read-more">
                                                    <a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>"
                                                       class="btn btn-secondary btn-sm"><?=Yii::t('app','Докладніше...')?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="block block-sidebar block-sidebar--position--end">
                    <div class="block-sidebar__item">
                        <div class="widget-search">
                            <form class="widget-search__body" action="/blogs/view">
                                <input class="widget-search__input" name="q" placeholder="<?=Yii::t('app','Пошук статтів...')?>" type="text"
                                       autocomplete="off" spellcheck="false">
                                <button class="search__button widget-search__button" type="submit">
                                    <svg width="20px" height="20px">
                                        <use xlink:href="/images/sprite.svg#search-20"></use>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php echo TagCloud::widget() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->render('@frontend/views/_partials/pagination', ['pages' => $pages]) ?>
<div class="container">
    <?php echo ProductsCarousel::widget() ?>
    <div class="spec__disclaimer">
        <?= $page_description ?>
    </div>
</div>

