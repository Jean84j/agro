<?php

use common\models\PostProducts;
use common\models\Posts;
use common\models\shop\ActivePages;
use common\models\shop\Product;
use common\models\shop\ProductImage;
use frontend\assets\PostPageAsset;
use frontend\widgets\LatestProduct;
use frontend\widgets\ProductsCarousel;
use frontend\widgets\TagCloud;
use yii\helpers\Url;

/** @var Posts $postItem */
/** @var Posts $blogs */
/** @var PostProducts $products_id */
/** @var Product $products */

PostPageAsset::register($this);
ActivePages::setActiveUser();
$webp_support = ProductImage::imageWebp();
$request = Yii::$app->request;
$currentUrl = $request->absoluteUrl;

?>
<div class="site__body">
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/"> <i class="fas fa-home"></i> <?= Yii::t('app', 'Головна') ?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= Url::to(['blogs/view']) ?>"><?= Yii::t('app', 'Статті') ?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $postItem->title ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="block post post--layout--classic">
                    <div class="post__header post-header post-header--layout--classic">
                        <h1 class="post-header__title"><?= $postItem->title ?></h1>
                        <div class="post-header__meta">
                            <div class="post-header__meta-item">
                                <span><?= Yii::$app->formatter->asDate($postItem->date_public) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="post__featured">
                        <?php if (Yii::$app->devicedetect->isMobile()) { ?>
                            <?php if ($webp_support == true && isset($post->webp_extra_large)) { ?>
                                <img src="/posts/<?= $postItem->webp_extra_large ?>" alt="<?= $postItem->title ?>">
                            <?php } else { ?>
                                <img src="/posts/<?= $postItem->extra_large ?>" alt="<?= $postItem->title ?>">
                            <?php } ?>
                        <?php } else { ?>
                            <?php if ($webp_support == true && isset($postItem->webp_image)) { ?>
                                <img src="/posts/<?= $postItem->webp_image ?>" alt="<?= $postItem->title ?>">
                            <?php } else { ?>
                                <img src="/posts/<?= $postItem->image ?>" alt="<?= $postItem->title ?>">
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <?php if ($postItem->slug === 'so-take-bordoska-sumis-i-comu-vona-vazliva') : ?>
                        <div style="display: flex; justify-content: center; margin-top: 20px;">
                            <a href="<?= Url::to(['product/view', 'slug' => 'fungitsid-bordos-ka-sumish-300g']) ?>"
                               class="btn-custom">
                                <?= Yii::t('app', 'Купити Бордоську суміш') ?>
                            </a>
                        </div>

                        <style>
                            .btn-custom {
                                display: inline-block;
                                padding: 12px 24px;
                                font-size: 18px;
                                font-weight: bold;
                                color: white;
                                background: linear-gradient(135deg, #ea7f32, rgba(231, 124, 25, 0.63)); /* Градиентный фон */
                                border: 3px solid #38a51a;
                                border-radius: 10px; /* Закругленные края */
                                text-decoration: none;
                                transition: all 0.3s ease-in-out;
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                            }

                            .btn-custom:hover {
                                background: linear-gradient(135deg, rgba(231, 124, 25, 0.63), #ea7f32); /* Меняем градиент при наведении */
                                transform: scale(1.05); /* Увеличиваем кнопку */
                                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
                            }

                            .btn-custom:active {
                                transform: scale(0.95); /* Эффект нажатия */
                            }
                        </style>
                    <?php endif; ?>
                    <div class="post__content typography ">
                        <p>
                            <?= $postItem->description ?>
                        </p>
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
                    <?php if ($products) { ?>
                        <?php echo LatestProduct::widget(['products' => $products,]) ?>
                    <?php } ?>
                    <div class="block-sidebar__item">
                        <div class="widget-posts widget">
                            <h4 class="widget__title"><?= Yii::t('app', 'Останні статті') ?></h4>
                            <div class="widget-posts__list">
                                <?php foreach ($blogs as $post): ?>
                                    <div class="widget-posts__item">
                                        <div class="widget-posts__image">
                                            <a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>">
                                                <?php if ($webp_support == true && isset($post->webp_small)) { ?>
                                                    <img src="/posts/<?= $post->webp_small ?>"
                                                         width="89" height="60"
                                                         alt="<?= $post->title ?>">
                                                <?php } else { ?>
                                                    <img src="/posts/<?= $post->small ?>"
                                                         width="89" height="60"
                                                         alt="<?= $post->title ?>">
                                                <?php } ?>
                                            </a>
                                        </div>
                                        <div class="widget-posts__info">
                                            <div class="widget-posts__name">
                                                <a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>"><?= $post->title ?></a>
                                            </div>
                                            <div class="widget-posts__date"><?= Yii::$app->formatter->asDate($post->date_public) ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php echo TagCloud::widget(['productsId' => $products_id]) ?>
                </div>
            </div>
        </div>
        <?php echo ProductsCarousel::widget() ?>
        <?= $this->render('review', ['postItem' => $postItem]) ?>
    </div>
</div>
<div id="additional-text" style="display: none;"><?= $currentUrl ?></div>