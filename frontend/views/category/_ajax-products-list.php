<?php

?>
<div id="products-wrapper">
    <div class="products-view__options">
        <div class="view-options view-options--offcanvas--mobile">
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
                'layout' => $layout,
                'products_all' => $products_all,
            ]) ?>

        </div>
    </div>

    <?= $this->render('/_partials/products-list', [
        'products' => $products,
        'layout' => $layout,
    ]) ?>
    <?= $this->render('/_partials/pagination', ['pages' => $pages]) ?>

</div>