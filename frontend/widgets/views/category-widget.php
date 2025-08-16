<?php

use yii\helpers\Url;

/** @var \common\models\shop\Category $categories */

?>
<?php if (Yii::$app->request->pathInfo == '') : ?>
<div class="departments  departments--open departments--fixed " data-departments-fixed-by=".block-slideshow">
    <?php else : ?>
    <div class="departments" data-departments-fixed-by="">
        <?php endif; ?>
        <div class="departments__body">
            <div class="departments__links-wrapper">
                <div class="departments__submenus-container"></div>
                <ul class="departments__links">
                    <?php
                    if ($categories): ?>
                        <?php foreach ($categories as $category): ?>
                            <?php if ($category->parents): ?>
                                <li class="departments__item">
                                    <a class="departments__item-link"
                                       href="<?= Url::to(['category/children', 'slug' => $category->slug]) ?>"><i
                                                class="bi-bug"></i>
                                        <?= $category->svg . ' ' . $category->name ?>
                                        <svg class="departments__item-arrow" width="6px" height="9px">
                                            <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                        </svg>
                                    </a>
                                    <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--xl">
                                        <div class="megamenu  megamenu--departments ">
                                            <div class="megamenu__body ">
                                                <div class="row">
                                                    <?php foreach ($category->parents as $parent): ?>
                                                        <?php if ($parent->products): ?>
                                                            <div class="col-4">
                                                                <ul class="megamenu__links megamenu__links--level--0">
                                                                    <li class="megamenu__item  megamenu__item--with-submenu ">
                                                                        <a href="<?= Url::to(['category/catalog', 'slug' => $parent->slug]) ?>"><?= $parent->svg . ' ' . $parent->name ?></a>
                                                                        <ul class="megamenu__links megamenu__links--level--1">
                                                                            <?php if ($parent->products): ?>
                                                                                <?php $i = 1;
                                                                                foreach ($parent->products as $product): ?>
                                                                                    <?php if ($i < 6): ?>
                                                                                        <li class="megamenu__item"><a
                                                                                                    href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $product->name ?></a>
                                                                                        </li>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($i == 6): ?>
                                                                                        <li class="megamenu__item">
                                                                                            <a href="<?= Url::to(['category/catalog', 'slug' => $parent->slug]) ?>">
                                                                                                <span style="color: #30b12b; "><?= Yii::t('app', 'Дивитись всі') ?>... </span>
                                                                                            </a>
                                                                                        </li>
                                                                                    <?php endif; ?>
                                                                                    <?php $i++; endforeach; ?>
                                                                            <?php endif; ?>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php else: ?>
                                <li class="departments__item">
                                    <a class="departments__item-link"
                                       href="<?= Url::to(['category/catalog', 'slug' => $category->slug]) ?>">
                                        <?= $category->svg . ' ' . $category->name ?>
                                    </a>
                                    <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--xl">
                                        <div class="megamenu  megamenu--departments ">
                                            <div class="megamenu__body ">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <ul class="megamenu__links megamenu__links--level--0">
                                                            <li class="megamenu__item  megamenu__item--with-submenu ">
                                                                <a href="<?= Url::to(['category/catalog', 'slug' => $category->slug]) ?>"><?= $category->svg . ' ' . $category->name ?></a>
                                                                <ul class="megamenu__links megamenu__links--level--1">
                                                                    <?php if ($category->products): ?>
                                                                        <?php $i = 1;
                                                                        foreach ($category->products as $product): ?>
                                                                            <?php if ($i < 6): ?>
                                                                                <li class="megamenu__item"><a
                                                                                            href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $product->name ?></a>
                                                                                </li>
                                                                            <?php endif; ?>
                                                                            <?php if ($i == 6): ?>
                                                                                <li class="megamenu__item">
                                                                                    <a href="<?= Url::to(['category/catalog', 'slug' => $category->slug]) ?>">
                                                                                        <span style="color: #30b12b; "><?= Yii::t('app', 'Дивитись всі') ?>... </span>
                                                                                    </a>
                                                                                </li>
                                                                            <?php endif; ?>
                                                                            <?php $i++; endforeach; ?>
                                                                    <?php endif; ?>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <button class="departments__button">
            <svg class="departments__button-icon" width="18px" height="14px">
                <use xlink:href="/images/sprite.svg#menu-18x14"></use>
            </svg>
            <span style="font-weight: bold; font-size: 18px">
            <?= Yii::t('app', 'Категорії товарів') ?>
            </span>
            <svg class="departments__button-arrow" width="9px" height="6px">
                <use xlink:href="/images/sprite.svg#arrow-rounded-down-9x6"></use>
            </svg>
        </button>
    </div>

