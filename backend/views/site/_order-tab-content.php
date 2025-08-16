<?php

use backend\widgets\OrderStatistic;
use backend\widgets\RecentOrders;

?>

<div class="row g-4 g-xl-5">
    <?php echo RecentOrders::widget() ?>
    <?php echo OrderStatistic::widget() ?>
</div>
