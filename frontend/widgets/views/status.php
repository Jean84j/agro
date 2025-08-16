<?php

/** @var \common\models\shop\Product $product */

?>

<div class="form-group product__option" style="font-size: 1rem; font-weight: 600; letter-spacing: 0.6px;">
    <?php $statusIcon = '';
    $statusStyle = '';

    switch ($product->status_id) {
        case 1:
            $statusIcon = '<i style="margin: 5px; color: #28a745;" class="fas fa-check"></i>';
            $statusStyle = 'color: #28a745;';
            break;
        case 2:
            $statusIcon = '<i style="margin: 5px; color: #ff0000;" class="fas fa-ban"></i>';
            $statusStyle = 'color: #ff0000;';
            break;
        case 3:
            $statusIcon = '<i style="margin: 5px; color: #ff8300;" class="fas fa-truck"></i>';
            $statusStyle = 'color: #ff8300;';
            break;
        case 4:
            $statusIcon = '<i style="margin: 5px; color: #0331fc;" class="fa fa-bars"></i>';
            $statusStyle = 'color: #0331fc;';
            break;
        default:
            $statusStyle = 'color: #060505;';
            break;
    }

    echo $statusIcon . '<span style="' . $statusStyle . '">' . Yii::t('app', $product->status->name) . '</span>';
    ?>
</div>