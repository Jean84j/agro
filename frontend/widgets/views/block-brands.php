<?php

/** @var \common\models\shop\Brand $brands */

?>
<div class="block block-brands">
    <div class="container">
        <div class="block-brands__slider">
            <div class="owl-carousel">
                <?php foreach ($brands as $brand): ?>
                    <div class="block-brands__item">
                        <a href="/brands/product-list/<?= $brand->slug ?>">
                            <img src="/images/brand/<?= $brand->file ?>" width="136" height="32" alt="<?= $brand->name ?>"
                                 loading="lazy">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>