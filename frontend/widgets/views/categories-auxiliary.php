<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $auxiliaryCategories */

?>
<div class="auxiliary tags tags--lg">
    <div class="tags__list">
        <?php foreach ($auxiliaryCategories as $auxiliaryCategory): ?>
            <?php
            $symbol = !empty($auxiliaryCategory->svg)
                ? '<span class="category-symbol">' . $auxiliaryCategory->svg . '</span>'
                : '<span class="category-symbol">🌱</span>';
            ?>
            <a href="<?= Url::to(['category/auxiliary-catalog', 'slug' => $auxiliaryCategory->slug]) ?>">
                <?= $symbol . ' ' . Html::encode($auxiliaryCategory->name) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<style>
    .auxiliary {
        border: 1px solid #47991f8f;
        border-radius: 4px;
        margin-bottom: 20px;
        padding: 10px 10px;
    }
    .category-symbol {
        font-size: 16px;
    }
</style>
