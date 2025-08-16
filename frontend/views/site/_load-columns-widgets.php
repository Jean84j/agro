<?php

use frontend\widgets\ColumnsBestsellers;
use frontend\widgets\ColumnsSpecialOffers;
use frontend\widgets\ColumnsTopRated;

?>

<div class="block block-product-columns d-lg-block d-none">
    <div class="container">
        <div class="row">
            <?php echo ColumnsTopRated::widget() ?>
            <?php echo ColumnsSpecialOffers::widget() ?>
            <?php echo ColumnsBestsellers::widget() ?>
        </div>
    </div>
</div>
