<?php

use common\models\shop\Product;

?>
<div class="widget-filters__item">
    <div class="filter filter--opened" data-collapse-item>
        <button type="button" class="filter__title"
                data-collapse-trigger>
            <?= Yii::t('app', 'Ціна') ?>
            <svg class="filter__arrow" width="12px" height="7px">
                <use xlink:href="/images/sprite.svg#arrow-rounded-down-12x7"></use>
            </svg>
        </button>
        <div class="filter__body" data-collapse-content>
            <?php
            $minPrice = round(Product::find()->min('price'), 2);
            $maxPrice = round(Product::find()->max('price'), 2);

            $request = Yii::$app->request;
            $submittedMinPrice = $request->post('minPrice', $minPrice);
            $submittedMaxPrice = $request->post('maxPrice', $maxPrice);
            ?>
            <div class="filter__container">
                <div class="filter-price" data-min="<?= $minPrice ?>"
                     data-max="<?= $maxPrice ?>"
                     data-from="<?= $submittedMinPrice ?>"
                     data-to="<?= $submittedMaxPrice ?>">
                    <div class="filter-price__slider"></div>
                    <div class="filter-price__title"><?= Yii::t('app', 'Ціна') ?>: ₴
                        <span class="filter-price__min-value"></span> –
                        ₴
                        <span class="filter-price__max-value"></span>
                        <input type="hidden" name="minPrice"
                               id="minPrice"
                               value="<?= $submittedMinPrice ?>"
                               class="filter-price__min-value"/>
                        <input type="hidden" name="maxPrice"
                               id="maxPrice"
                               value="<?= $submittedMaxPrice ?>"
                               class="filter-price__max-value"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
