<?php

use common\models\shop\ActivePages;
use yii\helpers\Url;

/** @var $products */
/** @var $categories */

ActivePages::setActiveUser();

?>
<?php if ($categories): ?>
    <ul class="categories-list">
        <?php foreach ($categories as $category): ?>
            <li>
                <?php if ($category['parentId'] == null && $category['products'] == 0): ?>
                    <a class="category-chip"
                       href="<?= Url::to(['category/children', 'slug' => $category['slug']]) ?>"><?= $category['name'] ?>
                    </a>
                <?php elseif ($category['parentId'] == null && $category['products'] == 2) : ?>
                    <a class="category-chip"
                       href="<?= Url::to(['category/auxiliary-catalog', 'slug' => $category['slug']]) ?>"><?= $category['name'] ?>
                    </a>
                <?php else: ?>
                    <a class="category-chip"
                       href="<?= Url::to(['category/catalog', 'slug' => $category['slug']]) ?>"><?= $category['name'] ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if ($products): ?>
    <ul class="suggestions__list">
        <?php foreach ($products as $product): ?>
            <li class="suggestions__item">
                <div class="suggestions__item-image product-image">
                    <div class="product-image__body">
                        <img class="product-image__img"
                             src="<?= $product->getImgOneExtraSmal($product->getId()) ?>"
                             width="44" height="44"
                             alt="<?= $product->name ?>">
                    </div>
                </div>
                <div class="suggestions__item-info">
                    <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>" class="suggestions__item-name">
                        <?= $product->name ?>
                    </a>
                    <div class="suggestions__item-meta">Артикул: <?= $product->sku ?></div>
                </div>
                <div class="suggestions__item-price">
                    <?= Yii::$app->formatter->asCurrency($product->getPrice()) ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (!$categories && !$products): ?>
    <ul class="suggestions__list">
        <li class="suggestions__item">
            <span class="no-values-available"><?= Yii::t('app', 'Товари відсутні') ?></span>
        </li>
    </ul>
<?php endif; ?>
<style>
    .no-values-available {
        color: rgba(255, 38, 38, 0.69);
        font-weight: bold;
    }

    .categories-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin: 5px 0;
        padding: 5px 15px;
        list-style: none;
    }

    .categories-list li {
        margin: 0;
    }

    .category-chip {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 999px;
        background: #e4f374;
        border: 1px solid #e3e7eb;
        color: #444;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: all .2s ease;
    }

    .category-chip:hover {
        background: #47991f;
        border-color: #47991f;
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(40, 167, 69, .25);
    }

    .category-chip:active {
        transform: translateY(0);
    }

    .category-chip:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, .2);
    }

</style>