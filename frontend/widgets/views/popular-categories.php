<?php

/** @var \common\models\shop\Category $categories */

?>

<div class="block block--highlighted block-categories block-categories--layout--classic">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title">Популярні Категорії</h3>
            <div class="block-header__divider"></div>
        </div>
        <div class="block-categories__list">
            <div class="block-categories__item category-card category-card--layout--classic">
                <div class="category-card__body">
                    <div class="category-card__image">
                        <a href=""><img src="/category/<?= $categories[0]->file ?>" alt=""></a>
                    </div>
                    <div class="category-card__content">
                        <div class="category-card__name">
                            <a href=""><?= $categories[0]->name ?></a>
                        </div>
                        <?php if ($categories[0]->parents): ?>
                            <ul class="category-card__links">
                                <?php foreach ($categories[0]->parents as $parent): ?>
                                    <li><a href=""><?= $parent->name ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <?php $i = 1;
            foreach ($categories as $category): ?>
                <?php if ($i >= 2): ?>
                    <div class="block-categories__item category-card category-card--layout--classic">
                        <div class="category-card__body">
                            <div class="category-card__image">
                                <a href=""><img src="/category/<?= $category->file ?>" alt=""></a>
                            </div>
                            <div class="category-card__content">
                                <div class="category-card__name">
                                    <a href=""><?= $category->name ?></a>
                                </div>
                                <?php if ($category->parents): ?>
                                    <ul class="category-card__links">
                                        <?php foreach ($category->parents as $parent): ?>
                                            <li><a href=""><?= $parent->name ?></a></li>
                                        <?php endforeach ?>
                                    </ul>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            <?php $i++; endforeach; ?>
        </div>
    </div>
</div>