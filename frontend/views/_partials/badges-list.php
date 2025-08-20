<?php

use yii\helpers\Html;

?>
<?php if (isset($product->label)): ?>
    <div class="product-card__badges-list">
        <div class="product-card__badge product-card__badge--new"
             style="background: <?= Html::encode($product->label->color) ?>;">
            <?= $product->label->name ?>
        </div>
        <?php if (isset($products_analog_count) && $products_analog_count > 0) : ?>
            <div class="product-card__badge product-card__badge--analog">
                <?= Yii::t('app', 'Є аналоги') . ' ' . $products_analog_count ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
