<?php

use backend\widgets\TopProductsBig;
use backend\widgets\TopProductsSmall;

?>
<div class="row g-4 g-xl-5">
    <?php echo TopProductsBig::widget() ?>
    <?php echo TopProductsSmall::widget() ?>
</div>
