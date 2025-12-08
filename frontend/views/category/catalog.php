<?php

use frontend\assets\CategoryCatalogPageAsset;
use common\models\shop\AuxiliaryCategories;
use common\models\shop\ActivePages;
use common\models\shop\Category;
use common\models\shop\Product;
use frontend\widgets\ViewProduct;
use yii\helpers\Html;
use yii\helpers\Url;

CategoryCatalogPageAsset::register($this);
ActivePages::setActiveUser();

/** @var Product $products */
/** @var Product $pages */
/** @var Product $products_all */
/** @var Product $propertiesFilter */
/** @var AuxiliaryCategories $auxiliaryCategories */
/** @var Category $category */

$h1 = $category->h1 ?: $category->name;

$breadcrumbItems = [];

$breadcrumbItems[] = [
    'url' => 'category/list',
    'item' => 'Категорії',
];
if (!empty($category->parent) && $category->parent->slug) {
    $breadcrumbItems[] = [
        'url' => 'category/children',
        'slug' => $category->parent->slug,
        'item' => $category->parent->name,
    ];
}

$breadcrumbItemActive = $category->name;

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'h1' => $h1,
            'breadcrumbItems' => $breadcrumbItems,
            'breadcrumbItemActive' => $breadcrumbItemActive,
        ]) ?>
    <?php echo Html::beginForm(Url::current(), 'post', ['class' => 'form-inline']); ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block">
                    <div class="products-view">
                        <?php if (!Yii::$app->devicedetect->isMobile()): ?>
                            <?php if (isset($auxiliaryCategories) && $auxiliaryCategories != null): ?>
                                <div class="tags tags--lg">
                                    <div class="tags__list">
                                        <?php $symbol = '<i class="fas fa-spa" style="color: #f8d105"></i>' ?>
                                        <?php foreach ($auxiliaryCategories as $auxiliaryCategory): ?>
                                            <a href="<?= Url::to(['category/auxiliary-catalog', 'slug' => $auxiliaryCategory->slug]) ?>">
                                                <?php echo $symbol . ' ' . $auxiliaryCategory->name ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <hr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="products-view__options">
                            <div class="view-options view-options--offcanvas--always">
                                <div class="view-options__filters-button">
                                    <button type="button" class="filters-button">
                                        <svg class="filters-button__icon" width="16px" height="16px">
                                            <use xlink:href="/images/sprite.svg#filters-16"></use>
                                        </svg>
                                        <span class="filters-button__title"><?= Yii::t('app', 'Фільтр') ?></span>
                                        <span class="filters-button__counter"><?= $category->getCounterFilter() ?></span>
                                    </button>
                                </div>

                                <?= $this->render('/_partials/products-sort', [
                                    'products' => $products,
                                    'products_all' => $products_all,
                                ]) ?>

                            </div>
                        </div>
                        <?= $this->render('/_partials/products-list', ['products' => $products]) ?>
                        <?= $this->render('filter/filter-sidebar',
                            [
                                'category' => $category,
                                'propertiesFilter' => $propertiesFilter,
                                'auxiliaryCategories' => $auxiliaryCategories,
                            ]) ?>
                        <?= $this->render('/_partials/pagination', ['pages' => $pages]) ?>
                        <div class="spec__disclaimer">
                            <?= $category->description ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Html::hiddenInput('slug', $category->slug);
    echo Html::endForm();?>
    <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
</div>
