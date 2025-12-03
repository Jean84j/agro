<?php

use frontend\assets\SuggestionsPageAsset;
use frontend\widgets\ViewProduct;
use common\models\shop\Product;
use yii\helpers\Html;
use yii\helpers\Url;

SuggestionsPageAsset::register($this);

/** @var Product $products */
/** @var Product $pages */
/** @var Product $products_all */

$h1 = 'Знайдено ' . $products_all . ' товарів за пошуковим запитом "'
    . Html::encode(Yii::$app->request->get('q')) . '"';
$breadcrumbItemActive = Html::encode(Yii::$app->request->get('q'));

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'h1' => $h1,
            'breadcrumbItemActive' => $breadcrumbItemActive,
        ]) ?>
    <?php
    echo Html::beginForm(Url::current(), 'post', ['class' => 'form-inline']); ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block">
                    <?php if ($products): ?>
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
                    <?php else: ?>
                        <span><?= Yii::t('app', 'Товари відсутні') ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo Html::endForm(); ?>
</div>