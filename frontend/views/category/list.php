<?php

use common\models\shop\ActivePages;
use frontend\assets\CategoryListPageAsset;
use yii\helpers\Url;

/** @var \common\models\shop\Product $categories */
/** @var \frontend\controllers\CategoryController $page_description */
/** @var  $files */

$h1 = 'Категорії';
$breadcrumbItemActive = 'Категорії';

CategoryListPageAsset::register($this);
ActivePages::setActiveUser();

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'files' => $files,
            'h1' => $h1,
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
                                <?php foreach ($categories as $category): ?>
                                    <div class="products-list__item">
                                        <div class="product-card ">
                                            <div class="product-card__image product-image">
                                                <?php if (empty($category->products)): ?>
                                                <a href="<?= Url::to(['category/children', 'slug' => $category->slug]) ?>"
                                                   class="product-image__body">
                                                    <?php else: ?>
                                                    <a href="<?= Url::to(['category/catalog', 'slug' => $category->slug]) ?>"
                                                       class="product-image__body">
                                                        <?php endif; ?>
                                                        <img class="product-image__img"
                                                             src="/images/category/<?= $category->file ?>"
                                                             width="231" height="231"
                                                             alt="<?= $category->name ?>">
                                                    </a>
                                            </div>
                                            <div class="product-card__info">
                                                <div class="product-card__name">
                                                    <?php if (empty($category->products)): ?>
                                                        <a href="<?= Url::to(['category/children', 'slug' => $category->slug]) ?>"><?= $category->name ?></a>
                                                    <?php else: ?>
                                                        <a href="<?= Url::to(['category/catalog', 'slug' => $category->slug]) ?>"><?= $category->name ?></a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="product-card__actions">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="spec__disclaimer">
                                <?= $page_description ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>