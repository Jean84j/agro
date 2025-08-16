<?php

use frontend\assets\CategoryCatalogPageAsset;
use common\models\shop\AuxiliaryCategories;
use common\models\shop\ActivePages;
use common\models\shop\Category;
use common\models\shop\Product;
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
                            <a href="<?= Url::to(['category/list']) ?>"><?= Yii::t('app', 'Категорії') ?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <?php if (isset($category->parent)): ?>
                            <li class="breadcrumb-item">
                                <a href="<?= Url::to(['category/children', 'slug' => $category->parent->slug]) ?>"><?= $category->parent->name ?></a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                        <?php endif; ?>
                        <li class="breadcrumb-item active" aria-current="page"><?= $category->name ?></li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1><?= $category->h1 ?: $category->name ?></h1>
            </div>
        </div>
    </div>
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
                                        <?php foreach ($auxiliaryCategories as $auxiliaryCategory): ?>
                                            <a href="<?= Url::to(['category/auxiliary-catalog', 'slug' => $auxiliaryCategory->slug]) ?>"><?php echo $auxiliaryCategory->name ?></a>
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

                                <?= $this->render('@frontend/views/layouts/products-sort.php', [
                                    'products' => $products,
                                    'products_all' => $products_all,
                                ]) ?>

                            </div>
                        </div>
                        <?= $this->render('@frontend/views/layouts/products-list.php', ['products' => $products]) ?>
                        <?= $this->render('filter-sidebar',
                            [
                                'category' => $category,
                                'propertiesFilter' => $propertiesFilter,
                                'auxiliaryCategories' => $auxiliaryCategories,
                            ]) ?>
                        <?= $this->render('@frontend/views/layouts/pagination.php', ['pages' => $pages]) ?>
                        <div class="spec__disclaimer">
                            <?= $category->description ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Html::hiddenInput('slug', $category->slug);
    echo Html::endForm();
    ?>
</div>
