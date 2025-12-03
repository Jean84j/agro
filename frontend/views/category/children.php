<?php

use common\models\shop\ActivePages;
use frontend\assets\CategoryChildrenPageAsset;
use frontend\widgets\ViewProduct;
use yii\helpers\Url;

/** @var \common\models\shop\Product $categories */
/** @var \common\models\shop\Product $category */

CategoryChildrenPageAsset::register($this);
ActivePages::setActiveUser();

$h1 = $category->h1 ?: $category->name;

$breadcrumbItems = [];

$breadcrumbItems[] = [
    'url' => 'category/list',
    'item' => 'Категорії',
];

$breadcrumbItemActive = $category->name;

?>
<div class="site__body">

    <?= $this->render('/_partials/page-header',
        [
            'h1' => $h1,
            'breadcrumbItems' => $breadcrumbItems,
            'breadcrumbItemActive' => $breadcrumbItemActive,
        ]) ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block">
                    <div class="products-view">
                        <div class="products-view__list products-list" data-layout="grid-4-full"
                             data-with-features="false" data-mobile-grid-columns="2">
                            <div class="products-list__body">
                                <?php foreach ($category->parents as $parent): ?>
                                    <?php if ($parent->visibility == 1): ?>
                                        <div class="products-list__item">
                                            <div class="product-card ">
                                                <div class="product-card__image product-image">
                                                    <a href="<?= Url::to(['category/catalog', 'slug' => $parent->slug]) ?>"
                                                       class="product-image__body">
                                                        <img class="product-image__img"
                                                             src="/images/category/<?= $parent->file ?>"
                                                             width="231" height="231"
                                                             alt="<?= $parent->name ?>">
                                                    </a>
                                                </div>
                                                <div class="product-card__info">
                                                    <div class="product-card__name">
                                                        <a href="<?= Url::to(['category/catalog', 'slug' => $parent->slug]) ?>"><?= $parent->name ?></a>
                                                    </div>
                                                </div>
                                                <div class="product-card__actions">
                                                    <div class="product-card__availability">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="spec__disclaimer">
                                <?= $category->description ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
</div>