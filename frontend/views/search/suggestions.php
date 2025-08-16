<?php

use common\models\shop\ActivePages;
use yii\helpers\Url;

ActivePages::setActiveUser();

?>
<ul class="suggestions__list">
    <?php if ($products): ?>
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
    <?php else: ?>
        <li class="suggestions__item">
            <span class="no-values-available"><?=Yii::t('app','Товари відсутні')?></span>
        </li>
    <?php endif; ?>
</ul>
<style>
    .no-values-available {
       color: rgba(255, 38, 38, 0.69);
        font-weight: bold;
    }
</style>