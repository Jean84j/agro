<?php

/** @var \common\models\shop\Category $categories */

use yii\helpers\Url;

?>
<div class="block block--highlighted block-categories block-categories--layout--classic">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title"><?= Yii::t('app', $title) ?></h3>
            <div class="block-header__divider"></div>
        </div>
        <div class="block-categories__list">
            <?php foreach ($categories as $category): ?>
                <div class="block-categories__item category-card category-card--layout--classic">
                    <div class="category-card__body">
                        <div class="category-card__image">
                            <?php if ($category->parentId == null) { ?>
                                <a href="<?= Url::to(['/catalog/' . $category->slug]) ?>"><img
                                            src="/images/category/<?= $category->file ?>" width="130" height="130"
                                            alt="<?= $category->name ?>" loading="lazy"></a>
                            <?php } else { ?>
                                <a href="<?= Url::to(['/product-list/' . $category->slug]) ?>"><img
                                            src="/images/category/<?= $category->file ?>" width="130" height="130"
                                            alt="<?= $category->name ?>" loading="lazy"></a>
                            <?php } ?>
                        </div>
                        <div class="category-card__content">
                            <div class="category-card__name">
                                <?php if ($category->parentId == null) { ?>
                                    <a href="<?= Url::to(['/catalog/' . $category->slug]) ?>"><?= $category->name ?></a>
                                <?php } else { ?>
                                    <a href="<?= Url::to(['/product-list/' . $category->slug]) ?>"><?= $category->name ?></a>
                                <?php } ?>
                            </div>
                            <div class="category-card__products" style="color: #a9a8a8">
                                <?= $category->getCountProductCategory($category->id) ?> <?= Yii::t('app', 'Товарів') ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>