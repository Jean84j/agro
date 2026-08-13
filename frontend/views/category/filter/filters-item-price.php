<?php
//dd($categoryMinPrice, $categoryMaxPrice, $minPrice, $maxPrice);
?>
<div class="widget-filters__item">
    <div class="filter filter--opened" data-collapse-item>
        <button type="button" class="filter__title" data-collapse-trigger>
            <?= Yii::t('app', 'Ціна') ?>
            <svg class="filter__arrow" width="12px" height="7px">
                <use xlink:href="/images/sprite.svg#arrow-rounded-down-12x7"></use>
            </svg>
        </button>
        <div class="filter__body" data-collapse-content>
            <div class="filter__container">
                <div class="filter-price"
                     data-min="<?= $categoryMinPrice ?>"
                     data-max="<?= $categoryMaxPrice ?>"
                     data-from="<?= $minPrice ?>"
                     data-to="<?= $maxPrice ?>">

                    <div class="filter-price__slider"></div>

                    <div class="filter-price__title"><?= Yii::t('app', 'Ціна') ?>: ₴
                        <span class="filter-price__min-value"></span> – ₴
                        <span class="filter-price__max-value"></span>

                        <!-- Инпуты обязаны иметь name, чтобы попали в serializeArray() формы -->
                        <input type="hidden" name="minPrice" id="minPrice" value="<?= $minPrice ?>"/>
                        <input type="hidden" name="maxPrice" id="maxPrice" value="<?= $maxPrice ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
