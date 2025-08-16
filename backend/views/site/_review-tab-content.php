<?php

use backend\widgets\PostReviews;
use backend\widgets\RecentReviews;

?>
<div class="row g-4 g-xl-5">
    <?php echo RecentReviews::widget() ?>
    <?php echo PostReviews::widget() ?>
</div>
