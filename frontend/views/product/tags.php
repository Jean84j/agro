<?php

use common\models\shop\Product;
use yii\helpers\Url;

/** @var Product $product */
/** @var Product $language */

?>
<hr class="hr-mod">
<div class="tags tags--lg">
    <div class="tags__list">
        <?php foreach ($product->tags as $tag): ?>
            <a href="<?= Url::to(['tag/view', 'slug' => $tag->slug]) ?>"><?= $tag->getTagTranslate($tag, $language) ?></a>
        <?php endforeach; ?>
    </div>
</div>
<hr class="hr-mod">