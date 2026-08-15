<?php

use yii\helpers\Html;

/** @var $products_all */
/** @var $filterBrandsItem */
/** @var $category_products_all */

?>
<div class="widget-filters__item">
    <div class="filter filter--opened" data-collapse-item>
        <button type="button" class="filter__title"
                data-collapse-trigger>
            <?= Yii::t('app', 'Бренд') ?>
            <svg class="filter__arrow" width="12px" height="7px">
                <use xlink:href="/images/sprite.svg#arrow-rounded-down-12x7"></use>
            </svg>
        </button>
        <div class="filter__body" data-collapse-content>
            <div class="filter__container">
                <div class="filter-list">
                    <div class="filter-list__list">
                        <?php
                        $selectedBrand = Yii::$app->session->get('filter_radio_brand_check', '');

                        $validBrandIds = array_column($filterBrandsItem, 'id');

                        if (!empty($selectedBrand) && !in_array($selectedBrand, $validBrandIds)) {
                            $selectedBrand = '';
                            Yii::$app->session->set('filter_radio_brand_check', '');
                        }
                        ?>

                        <label class="filter-list__item">
        <span class="filter-list__input input-radio">
            <span class="input-radio__body">
                <input class="input-radio__input filter-change-trigger"
                       name="filter_radio_brand"
                       type="radio"
                       value=""
                       <?= (empty($selectedBrand)) ? 'checked' : '' ?>
                >
                <span class="input-radio__circle"></span>
            </span>
        </span>
                            <span class="filter-list__title">Всі продукти</span>
                            <span class="filter-list__counter"><?= $category_products_all ?></span>
                        </label>

                        <?php foreach ($filterBrandsItem as $brand): ?>
                            <label class="filter-list__item">
            <span class="filter-list__input input-radio">
                <span class="input-radio__body">
                    <input class="input-radio__input filter-change-trigger"
                           name="filter_radio_brand"
                           type="radio"
                           value="<?= Html::encode($brand['id']) ?>"
                           <?= ($brand['id'] == $selectedBrand) ? 'checked' : '' ?>
                    >
                    <span class="input-radio__circle"></span>
                </span>
            </span>
                                <span class="filter-list__title"><?= Html::encode($brand['name']) ?></span>
                                <span class="filter-list__counter">

                                    <?= $brand['count'] ?>

                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
