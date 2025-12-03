<?php

use frontend\assets\CategoryAuxiliaryPageAsset;
use common\models\shop\ActivePages;
use common\models\shop\Product;
use yii\helpers\Html;
use yii\helpers\Url;

CategoryAuxiliaryPageAsset::register($this);
ActivePages::setActiveUser();

/** @var Product $products */
/** @var Product $pages */
/** @var Product $products_all */
/** @var $breadcrumbCategory */
/** @var $category */

$h1 = $category->h1 ?: $category->name;

$breadcrumbItems = [];

$breadcrumbItems[] = [
    'url' => 'category/list',
    'item' => 'Категорії',
];

$breadcrumbItems[] = [
    'url' => 'category/catalog',
    'slug' => $breadcrumbCategory->slug,
    'item' => $breadcrumbCategory->name,
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
    <?php
    echo Html::beginForm(Url::current(), 'post', ['class' => 'form-inline']); ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block">
                    <div class="products-view">
                        <div class="products-view__options">
                            <div class="view-options view-options--offcanvas--always">
                                <?= $this->render('@frontend/views/_partials/products-sort', [
                                    'products' => $products,
                                    'products_all' => $products_all,
                                ]) ?>
                            </div>
                        </div>
                        <?= $this->render('@frontend/views/_partials/products-list', ['products' => $products]) ?>
                        <?= $this->render('@frontend/views/_partials/pagination', ['pages' => $pages]) ?>
                        <div class="spec__disclaimer">
                            <?= $category->description ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Html::endForm(); ?>
</div>
