<?php

use common\models\shop\ActivePages;
use frontend\assets\CategoryChildrenPageAsset;
use yii\helpers\Url;

/** @var \common\models\shop\Brand $brands */
/** @var  \frontend\controllers\BrandsController $page_description */

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
                            <a href="/"> <i class="fas fa-home"></i> <?= Yii::t('app', 'Головна') ?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active"
                            aria-current="page"><?= Yii::t('app', 'Бренди') ?>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1><?= Yii::t('app', 'Бренди') ?></h1>
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
                                <?php foreach ($brands as $brand): ?>
                                    <div class="products-list__item">
                                        <div class="product-card ">
                                            <div class="product-card__image product-image">
                                                <a href="<?= Url::to(['brands/catalog', 'slug' => $brand->slug]) ?>"
                                                   class="product-image__body" style="padding-bottom: 50%">
                                                    <img class="product-image__img"
                                                         src="/images/brand/<?= $brand->file ?>"
                                                         width="231" height="231"
                                                         alt="<?= $brand->name ?>">
                                                </a>
                                            </div>
                                            <div class="product-card__info">
                                                <div class="product-card__name"
                                                     style="font-size: 18px; background: rgba(238,211,58,0.77); padding: 5px 5px; border-radius: 3px">
                                                    <a href="<?= Url::to(['brands/catalog', 'slug' => $brand->slug]) ?>">
                                                        <?= $brand->name ?></a>
                                                </div>
                                                <hr>
                                                <div class="product-card__availability"
                                                     style="background: rgba(143,209,158,0.7); padding-left: 5px">
                                                    <?= Yii::t('app', 'к-ть товарів:') ?>
                                                    <span style="font-weight: bold; font-size: 18px; color: #0f0101">
                                                        <?= '   ' . $brand->getProductBrand($brand->id) ?>
                                                        </span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="product-card__actions">
                                                <div class="product-card__availability">
                                                    <?= $brand->getBrandCategories($brand->id) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="spec__disclaimer">
                                <?php if ($page_description): ?>
                                    <?= $page_description ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>