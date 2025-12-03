<?php

use common\models\shop\ProductProperties;
use frontend\assets\ProductPageAsset;
use frontend\widgets\RelatedProducts;
use common\models\shop\ActivePages;
use frontend\widgets\ViewProduct;
use common\models\shop\Product;
use common\models\shop\Review;
use common\models\shop\Brand;

/** @var ProductProperties $product_properties */
/** @var Product $products_analog_count */
/** @var Product $products_analog */
/** @var Product $isset_to_cart */
/** @var Review $model_review */
/** @var yii\web\View $this */
/** @var Product $products */
/** @var Product $product */
/** @var Brand $img_brand */
/** @var Product $images */

ProductPageAsset::register($this);
ActivePages::setActiveUser();

$breadcrumbItems = [];

$breadcrumbItems[] = [
    'url' => 'category/list',
    'item' => 'Категорії',
];
if (!empty($product->category->parent) && $product->category->parent->slug) {
    $breadcrumbItems[] = [
        'url' => 'category/children',
        'slug' => $product->category->parent->slug,
        'item' => $product->category->parent->name,
    ];
}
$breadcrumbItems[] = [
    'url' => 'category/catalog',
    'slug' => $product->category->slug,
    'item' => $product->category->name,
];

$breadcrumbItemActive = $product->name;

?>
    <div class="site__body">
        <?= $this->render('/_partials/page-header',
            [
                'breadcrumbItems' => $breadcrumbItems,
                'breadcrumbItemActive' => $breadcrumbItemActive,
            ]) ?>
        <div class="block">
            <div class="container">
                <div class="product product--layout--columnar" data-layout="columnar">
                    <div class="product__content">
                        <?= $this->render('product-gallery', [
                            'product' => $product,
                            'language' => $language,
                            'images' => $images,
                            'mobile' => $mobile,
                            'webp_support' => $webp_support,
                            'products_analog_count' => $products_analog_count,
                        ]) ?>
                        <?= $this->render('product-info', [
                            'product' => $product,
                            'productVariants' => $productVariants,
                            'language' => $language,
                            'product_properties' => $product_properties,
                            'mobile' => $mobile,
                        ]) ?>
                        <?= $this->render('sidebar', [
                            'mobile' => $mobile,
                            'product' => $product,
                            'img_brand' => $img_brand,
                            'isset_to_cart' => $isset_to_cart,
                            'products_analog' => $products_analog,
                            'products_analog_count' => $products_analog_count,
                            'minimumOrderAmount' => $minimumOrderAmount,
                        ]) ?>
                    </div>
                </div>
                <?= $this->render('description', [
                    'product' => $product,
                    'mobile' => $mobile,
                    'faq' => $faq,
                    'product_properties' => $product_properties,
                    'model_review' => $model_review,
                    'products_analog' => $products_analog,
                    'products_analog_count' => $products_analog_count,
                ]) ?>
                <?php if ($mobile): ?>
                    <?php if ($this->beginCache('tags-product-mobile_' . $language . $product->id, ['duration' => 3600])): ?>
                        <div style="margin-left: 15px;">
                            <?= $this->render('tags', [
                                'product' => $product,
                                'language' => $language,
                            ]) ?>
                        </div>
                        <?php $this->endCache() ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!$mobile): ?>
            <?php if ($this->beginCache('related-product_' . $language . $product->id, ['duration' => 3600])): ?>
                <?php echo RelatedProducts::widget(['package' => $product->package,]) ?>
                <?php $this->endCache() ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($mobile): ?>
            <div class="container">
                <?= $this->render('info-accordion', [
                    'product' => $product,
                    'mobile' => $mobile,
                    'img_brand' => $img_brand,
                ]) ?>
            </div>
        <?php endif; ?>
        <?php echo ViewProduct::widget(['id' => $product->id,]) ?>
    </div>
<?= $this->render('@frontend/views/layouts/photoswipe.php') ?>