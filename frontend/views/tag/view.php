<?php

use common\models\shop\ActivePages;
use common\models\shop\Product;
use frontend\assets\TagPageAsset;
use frontend\controllers\TagController;
use frontend\widgets\ViewProduct;
use yii\helpers\Html;
use yii\helpers\Url;

TagPageAsset::register($this);
ActivePages::setActiveUser();

/** @var Product $products */
/** @var Product $pages */
/** @var TagController $tag_name */
/** @var TagController $language */
/** @var TagController $products_all */
/** @var TagController $categoryName */

$h1 = Yii::t('app', 'Продукти пов`язані тегом ') . '"' .
    '<span style="color: #90998cc7">' .
    $tag_name->getTagTranslate($tag_name, $language) .
    '</span>' . '" ' . $categoryName;

$breadcrumbItems = [];

$breadcrumbItems[] = [
    'url' => 'tag/index',
    'item' => Yii::t('app', 'Теги'),
];

$breadcrumbItemActive = Yii::t('app', 'Продукти запиту');

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
                        <?php if (isset($categories) && $categories != null): ?>
                            <div class="tags tags--lg">
                                <div class="tags__list">
                                    <?php foreach ($categories as $category): ?>
                                        <a href="<?= Url::to(['tag/view', 'slug' => $tag_name->slug, 'category_slug' => $category->slug]) ?>"><?php echo $category->name ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <hr>
                        <?php endif; ?>
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
                        <br>
                        <div class="spec__disclaimer">
                            <?= $tag_name->getDescriptionTranslate($tag_name, $language) ?>
                        </div>
                        <br>
                        <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Html::hiddenInput('id', $tag_name->id);
    echo Html::endForm();
    ?>
</div>