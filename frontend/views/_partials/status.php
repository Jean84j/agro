<?php

/** @var \common\models\shop\Product $product */

?>
<div class="product-card__availability">
    <div class="form-group product__option" style="font-size: 1rem; font-weight: 600; letter-spacing: 0.6px;">
        <?php
        $statusIcon = '<i style="margin: 5px; color: ' . $product->status->color .
            ';" class="' . $product->status->icon . '"></i>';
        $statusStyle = 'color: ' . $product->status->color . ';';
        ?>
        <?= $statusIcon . '<span style="' . $statusStyle . '">' .
        Yii::t('app', $product->status->name) . '</span>'; ?>
    </div>
</div>