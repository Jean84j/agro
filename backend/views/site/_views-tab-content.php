<?php

use backend\widgets\PostViews;
use backend\widgets\RecentActivity;

?>
<div class="row g-4 g-xl-5">
    <?php echo RecentActivity::widget() ?>
    <?php echo PostViews::widget() ?>
</div>
