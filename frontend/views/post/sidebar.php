<?php

use common\models\PostProducts;
use common\models\Posts;
use common\models\shop\Product;
use frontend\widgets\LatestProduct;
use frontend\widgets\TagCloud;
use yii\helpers\Url;

/** @var Posts $blogs */
/** @var PostProducts $products_id */
/** @var Product $products */
/** @var $webp_support */

?>
<div class="col-12 col-lg-4">
    <div class="block block-sidebar block-sidebar--position--end">
        <div class="block-sidebar__item">
            <div class="widget-search">
                <form class="widget-search__body" action="/blogs/view">
                    <input class="widget-search__input" name="q"
                           placeholder="<?= Yii::t('app', 'Пошук статтів...') ?>" type="text"
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
