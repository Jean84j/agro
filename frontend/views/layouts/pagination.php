<?php

use common\models\shop\Product;
use yii\bootstrap5\LinkPager;

/** @var Product $pages */

?>
<div class="mt-4 mb-4">
    <div class="d-flex justify-content-center">
        <?= LinkPager::widget([
            'pagination' => $pages,
            'options' => ['class' => 'pagination'],
            'linkOptions' => ['class' => 'page-link'],
            'activePageCssClass' => 'active',
            'disabledPageCssClass' => 'disabled',
            'nextPageLabel' => '»',
            'prevPageLabel' => '«',
        ]); ?>
    </div>
</div>
