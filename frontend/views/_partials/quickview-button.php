<?php

use common\models\shop\Product;

/** @var Product $product */

$urlOpen = Yii::$app->urlManager->createUrl(['quickview/quickview']);

$number = mt_rand(10, 99);

?>
<button class="product-card__quickview gtm-quickview"
        type="button"
        id="quickview-<?= $product->id . $number ?>"
        data-product-id="<?= $product->id ?>"
        data-url-quickview="<?= $urlOpen ?>"
        aria-label="Швидкий перегляд"
>
    <i class="fas fa-expand gtm-quickview" style="font-size: 24px; color: rgba(223,159,10,0.8)"></i>
    <span class="fake-svg-icon"></span>
</button>
