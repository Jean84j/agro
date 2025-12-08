<?php

use yii\helpers\Html;

/** @var $category */
/** @var $propertiesFilter */

?>
<div class="block block-sidebar block-sidebar--offcanvas--always">
    <div class="block-sidebar__backdrop"></div>
    <div class="block-sidebar__body">
        <div class="block-sidebar__header">
            <div class="block-sidebar__title"><?= Yii::t('app', 'Фільтр') ?></div>
            <button class="block-sidebar__close" type="button">
                <svg width="20px" height="20px">
                    <use xlink:href="/images/sprite.svg#cross-20"></use>
                </svg>
            </button>
        </div>
        <div class="block-sidebar__item">
            <div class="widget-filters widget widget-filters--offcanvas--always"
                 data-collapse
                 data-collapse-opened-class="filter--opened">
                <h4 class="widget-filters__title widget__title"><?= Yii::t('app', 'Фільтр') ?></h4>
                <div class="widget-filters__list">
                    <?= $this->render('filters-item-categories', ['category' => $category]) ?>

                    <?php if (isset($auxiliaryCategories) and $auxiliaryCategories != null): ?>
                        <?= $this->render('filters-item-auxiliary', ['auxiliaryCategories' => $auxiliaryCategories]) ?>
                    <?php endif; ?>
                    <?= $this->render('filters-item-price') ?>

                    <?= $this->render('filters-item-brands', ['category' => $category]) ?>

                    <?= $this->render('filters-item-properties', [
                        'category' => $category,
                        'propertiesFilter' => $propertiesFilter,
                    ]) ?>
                </div>
                <div class="widget-filters__actions d-flex">
                    <button type="submit" class="btn btn-primary btn-sm"><?= Yii::t('app', 'Фільтрувати') ?>
                    </button>
                    <?= Html::a(Yii::t('app', 'Скинути'), ['product-list/' . $category->slug], ['class' => 'btn btn-secondary btn-sm']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
