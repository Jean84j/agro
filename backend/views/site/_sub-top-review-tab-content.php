<?php

use backend\widgets\SubTopProducts;
use backend\widgets\SubTopPosts;

?>
<div class="row g-4 g-xl-5">
    <?php echo SubTopProducts::widget() ?>
    <?php echo SubTopPosts::widget() ?>
</div>
