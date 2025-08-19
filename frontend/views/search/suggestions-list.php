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

?>
<div class="site__body">
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/"><?= Yii::t('app', 'Головна') ?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active"
                            aria-current="page"><?= Html::encode(Yii::$app->request->get('q')) ?></li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>Знайдено <?php echo $products_all ?> товарів за пошуковим запитом
                    "<?= Html::encode(Yii::$app->request->get('q')) ?>"</h1>
            </div>
        </div>
    </div>
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