<?php

use frontend\assets\SpecialPageAsset;
use common\models\shop\ActivePages;
use frontend\widgets\ViewProduct;
use common\models\shop\Product;
use yii\helpers\Html;
use yii\helpers\Url;

SpecialPageAsset::register($this);
ActivePages::setActiveUser();

/** @var Product $products */
/** @var Product $pages */
/** @var Product $products_all */
/** @var Product $brand */

$breadcrumbItems = [];

$breadcrumbItems[] = [
    'url' => '/brands',
    'item' => Yii::t('app', 'Бренди'),
];

$breadcrumbItemActive = Yii::t('app', 'Товари бренду') . ' ' . $brand->name;

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'breadcrumbItems' => $breadcrumbItems,
            'breadcrumbItemActive' => $breadcrumbItemActive,
        ]) ?>
    <?php echo Html::beginForm(Url::current(), 'post', ['class' => 'form-inline']); ?>
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
                        <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Html::endForm(); ?>
</div>
