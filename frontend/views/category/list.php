<?php
use yii\helpers\Url;

/** @var \common\models\shop\Product $categories */

?>

<!-- site__body -->
<div class="site__body">
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">Головна</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/frontend/web/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Категорії</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>Категорії</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block">
                    <div class="products-view">
                         <div class="products-view__list products-list" data-layout="grid-4-full" data-with-features="false" data-mobile-grid-columns="2">
                            <div class="products-list__body">
                                <?php foreach ($categories as $category): ?>
                                <div class="products-list__item">
                                    <div class="product-card product-card--hidden-actions ">
                                        <div class="product-card__image product-image">
                                            <?php if(empty($category->products)): ?>
                                            <a href="<?=Url::to(['category/children', 'slug' => $category->slug])?>" class="product-image__body">
                                            <?php else: ?>
                                            <a href="<?=Url::to(['category/catalog', 'slug' => $category->slug])?>" class="product-image__body">
                                            <?php endif; ?>
                                                <img class="product-image__img" src="/category/<?= $category->file ?>" alt="">
                                            </a>
                                        </div>
                                        <div class="product-card__info">
                                            <div class="product-card__name">
                                                <a href="<?=Url::to(['category/children', 'slug' => $category->slug])?>"><?= $category->name ?></a>
                                            </div>
                                        </div>
                                        <div class="product-card__actions">
                                            <div class="product-card__availability">
                                                Availability: <span class="text-success">In Stock</span>
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
        </div>
    </div>
</div>
<!-- site__body / end -->
