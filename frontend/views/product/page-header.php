<?php

use yii\helpers\Url;

?>
<div class="page-header">
    <div class="page-header__container container">
        <div class="page-header__breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-anim">
                    <li class="breadcrumb-item">
                        <a href="/" aria-label="AgroPro — на головну"> <i class="fas fa-home"></i> <?= Yii::t('app', 'Головна') ?> </a>
                        <svg class="breadcrumb-arrow" width="6px" height="9px">
                            <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                        </svg>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= Url::to(['category/list']) ?>" aria-label="Категорії"><?= Yii::t('app', 'Категорії') ?></a>
                        <svg class="breadcrumb-arrow" width="6px" height="9px">
                            <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                        </svg>
                    </li>
                    <?php if (isset($product->category->parent)): ?>
                        <li class="breadcrumb-item">
                            <a href="<?= Url::to(['category/children', 'slug' => $product->category->parent->slug]) ?>" aria-label="<?= $product->category->parent->name ?>"><?= $product->category->parent->name ?></a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                    <?php endif; ?>
                    <li class="breadcrumb-item">
                        <a href="<?= Url::to(['category/catalog', 'slug' => $product->category->slug]) ?>"  aria-label="<?= $product->category->name ?>"><?= $product->category->name ?></a>
                        <svg class="breadcrumb-arrow" width="6px" height="9px">
                            <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                        </svg>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $product->name ?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>
