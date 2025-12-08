<?php

use yii\helpers\Url;

/** @var $category */

?>
<div class="widget-filters__item">
    <div class="filter filter--opened" data-collapse-item>
        <button type="button" class="filter__title"
                data-collapse-trigger>
            <?= Yii::t('app', 'Категорії') ?>
            <svg class="filter__arrow" width="12px" height="7px">
                <use xlink:href="/images/sprite.svg#arrow-rounded-down-12x7"></use>
            </svg>
        </button>
        <div class="filter__body" data-collapse-content>
            <div class="filter__container">
                <div class="filter-categories">
                    <ul class="filter-categories__list">
                        <li class="filter-categories__item filter-categories__item--parent">
                            <svg class="filter-categories__arrow"
                                 width="6px"
                                 height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-left-6x9"></use>
                            </svg>
                            <?php if ($category->parent) { ?>
                                <a href="<?= Url::to(['category/children', 'slug' => $category->parent->slug]) ?>"><?= $category->parent->name ?></a>
                            <?php } else { ?>
                                <a href="<?= Url::to(['category/catalog', 'slug' => $category->slug]) ?>"><?= $category->name ?></a>
                            <?php } ?>
                            <div class="filter-categories__counter">
                                <?= ($category->parent) ? $category->getCountProductCategoryFilter($category->parent->id) : $category->getCountProductCategoryFilter($category->id); ?>
                            </div>
                        </li>
                        <?php if ($category->parent): ?>
                            <?php if ($category->parent->parents): ?>
                                <?php foreach ($category->parent->parents as $categoryChild): ?>
                                    <?php if ($categoryChild->visibility == 1): ?>
                                        <?php if ($category->id == $categoryChild->id) { ?>
                                            <li class="filter-categories__item filter-categories__item--current">
                                                <a href="<?= Url::to(['category/catalog', 'slug' => $categoryChild->slug]) ?>"><?= $categoryChild->name ?></a>
                                                <div class="filter-categories__counter"><?= $categoryChild->getCountProductCategoryFilter($categoryChild->id) ?></div>
                                            </li>
                                        <?php } else { ?>
                                            <li class="filter-categories__item filter-categories__item--child">
                                                <a href="<?= Url::to(['category/catalog', 'slug' => $categoryChild->slug]) ?>"><?= $categoryChild->name ?></a>
                                                <div class="filter-categories__counter"><?= $categoryChild->getCountProductCategoryFilter($categoryChild->id) ?></div>
                                            </li>
                                        <?php } ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
