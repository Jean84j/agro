<?php

/** @var $product */

?>
<div class="product-card__prices">
    <?php if ($product->old_price == null) : ?>
        <?= Yii::$app->formatter->asCurrency($product->getPrice()) ?>
    <?php  else : ?>
        <span class="product-card__new-price"><?= Yii::$app->formatter->asCurrency($product->getPrice()) ?></span>
        <span class="product-card__old-price"><?= Yii::$app->formatter->asCurrency($product->getOldPrice()) ?></span>
    <?php endif; ?>
</div>
