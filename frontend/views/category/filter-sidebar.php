<?php

use common\models\shop\Product;
use yii\helpers\Html;
use yii\helpers\Url;

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
                    <?php if (isset($auxiliaryCategories) and $auxiliaryCategories != null): ?>
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
                    <?php endif; ?>
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
                    <div class="widget-filters__item">
                        <div class="filter" data-collapse-item>
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
                                            <?php $brandsCategory = $category->getBrandsCategoryFilter($category->id) ?>
                                            <?php foreach ($brandsCategory as $brand): ?>
                                                <label class="filter-list__item ">
                                                                <span class="filter-list__input input-check">
                                                                    <span class="input-check__body">
                                                                        <input class="input-check__input"
                                                                               type="checkbox"
                                                                               name="brandCheck[]"
                                                                               value="<?= Html::encode($brand->id) ?>"
                                                                               <?= in_array($brand->id, Yii::$app->request->post('brandCheck', [])) ? 'checked' : '' ?>
                                                                               >
                                                                        <span class="input-check__box"></span>
                                                                        <svg class="input-check__icon" width="9px"
                                                                             height="7px">
                                                                            <use xlink:href="/images/sprite.svg#check-9x7"></use>
                                                                        </svg>
                                                                    </span>
                                                                </span>
                                                    <span class="filter-list__title">
                                                                 <?= $brand->name ?>
                                                                </span>
                                                    <span class="filter-list__counter"><?= $brand->getBrandProductCountFilter($brand->id, $category->id) ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($propertiesFilter as $value): ?>
                        <div class="widget-filters__item">
                            <div class="filter" data-collapse-item>
                                <button type="button" class="filter__title"
                                        data-collapse-trigger>
                                    <?= $value['name'] ?>
                                    <svg class="filter__arrow" width="12px" height="7px">
                                        <use xlink:href="/images/sprite.svg#arrow-rounded-down-12x7"></use>
                                    </svg>
                                </button>
                                <div class="filter__body" data-collapse-content>
                                    <div class="filter__container">
                                        <div class="filter-list">
                                            <div class="filter-list__list">
                                                <?php $properties = $category->getPropertiesFilter($value['category_id'], $value['property_id']) ?>
                                                <?php foreach ($properties as $property): ?>
                                                    <label class="filter-list__item ">
                                                                <span class="filter-list__input input-check">
                                                                    <span class="input-check__body">
                                                                        <input class="input-check__input"
                                                                               type="checkbox"
                                                                               name="propertiesCheck[]"
                                                                               value="<?= Html::encode($property) ?>"
                                                                               <?= in_array($property, Yii::$app->request->post('propertiesCheck', [])) ? 'checked' : '' ?>
                                                                               >
                                                                        <span class="input-check__box"></span>
                                                                        <svg class="input-check__icon" width="9px"
                                                                             height="7px">
                                                                            <use xlink:href="/images/sprite.svg#check-9x7"></use>
                                                                        </svg>
                                                                    </span>
                                                                </span>
                                                        <span class="filter-list__title">
                                                                  <?= $property ?>
                                                                </span>
                                                        <span class="filter-list__counter">
                                                                                        <?= $category->getPropertiesCountPruductFilter
                                                                                        ($category->id, $property) ?>
                                                                                    </span>
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
