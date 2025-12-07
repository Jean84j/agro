<?php

use common\models\shop\ProductProperties;

/** @var ProductProperties $product_properties */
/** @var $language */
/** @var $productId */

?>
<?php if ($this->beginCache('product_properties-product_' . $language . $productId, ['duration' => 3600])): ?>
    <?php if ($product_properties != null) { ?>
        <?php foreach ($product_properties as $property): ?>
            <?php if ($property['value'] && $property['value'] != '*'): ?>
                <div class="spec__row">
                    <div class="spec__name"><?= $property['properties'] ?>:</div>
                    <div class="spec__value"><?= $property['value'] ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php } else { ?>
        <div class="spec__row">
            <div class="spec__name">- - -</div>
            <div class="spec__value">- - -</div>
        </div>
        <div class="spec__row">
            <div class="spec__name">- - -</div>
            <div class="spec__value">- - -</div>
        </div>
        <div class="spec__row">
            <div class="spec__name">- - -</div>
            <div class="spec__value">- - -</div>
        </div>
    <?php } ?>
    <?php $this->endCache() ?>
<?php endif; ?>