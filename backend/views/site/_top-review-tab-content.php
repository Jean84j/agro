<?php

use backend\widgets\TopPosts;
use backend\widgets\TopProducts;

?>
<div class="row g-4 g-xl-5">
    <?php echo TopProducts::widget() ?>
    <?php echo TopPosts::widget() ?>
</div>
