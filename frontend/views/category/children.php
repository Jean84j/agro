<?php

use common\models\shop\ActivePages;
use frontend\assets\CategoryChildrenPageAsset;
use yii\helpers\Url;

/** @var \common\models\shop\Product $categories */

CategoryChildrenPageAsset::register($this);
ActivePages::setActiveUser();

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
                        <li class="breadcrumb-item">
                            <a href="<?= Url::to(['category/list']) ?>"><?=Yii::t('app','Категорії')?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/frontend/web/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $category->name ?></li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1><?= $category->h1 ?: $category->name ?></h1>
            </div>
        </div>
    </div>
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
</div>