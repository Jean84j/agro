<?php

use common\models\PostProducts;
use common\models\Posts;
use common\models\shop\ActivePages;
use common\models\shop\Product;
use common\models\shop\ProductImage;
use frontend\assets\PostPageAsset;
use frontend\widgets\ProductsCarousel;
use yii\helpers\Url;

/** @var Posts $postItem */
/** @var Posts $blogs */
/** @var PostProducts $products_id */
/** @var Product $products */

PostPageAsset::register($this);
ActivePages::setActiveUser();

$breadcrumbItems = [];

$breadcrumbItems[] = [
    'url' => 'blogs/view',
    'item' => Yii::t('app', 'Статті'),
];

$breadcrumbItemActive = $postItem->title;

$webp_support = ProductImage::imageWebp();
$request = Yii::$app->request;
$currentUrl = $request->absoluteUrl;

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'breadcrumbItems' => $breadcrumbItems,
            'breadcrumbItemActive' => $breadcrumbItemActive,
        ]) ?>
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
            <?= $this->render('sidebar',
                [
                    'products' => $products,
                    'blogs' => $blogs,
                    'webp_support' => $webp_support,
                    'products_id' => $products_id,
                ]) ?>
        </div>
        <?php echo ProductsCarousel::widget() ?>
        <?= $this->render('review', ['postItem' => $postItem]) ?>
    </div>
</div>
<div id="additional-text" style="display: none;"><?= $currentUrl ?></div>