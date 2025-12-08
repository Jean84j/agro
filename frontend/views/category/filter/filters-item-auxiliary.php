<?php

use yii\helpers\Url;

?>
<div class="widget-filters__item">
    <div class="filter filter--opened" data-collapse-item>
        <button type="button" class="filter__title"
                data-collapse-trigger>
            <?= Yii::t('app', 'Категорії допоміжні') ?>
            <svg class="filter__arrow" width="12px" height="7px">
                <use xlink:href="/images/sprite.svg#arrow-rounded-down-12x7"></use>
            </svg>
        </button>
        <div class="filter__body" data-collapse-content>
            <div class="filter__container">
                <div class="filter-categories-alt">
                    <ul class="filter-categories-alt__list filter-categories-alt__list--level--1"
                        data-collapse-opened-class="filter-categories-alt__item--open">
                        <?php foreach ($auxiliaryCategories as $auxiliaryCategory): ?>
                            <li class="filter-categories-alt__item"
                                data-collapse-item>
                                <a href="<?= Url::to(['category/auxiliary-catalog', 'slug' => $auxiliaryCategory->slug]) ?>"><?php echo $auxiliaryCategory->name ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
