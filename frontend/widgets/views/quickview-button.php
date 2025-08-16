<?php

$urlOpen = Yii::$app->urlManager->createUrl(['quickview/quickview']);

?>
<button class="product-card__quickview"
        type="button"
        id="add-to-cart"
        data-product-id="<?= $product->id ?>"
        data-url-quickview="<?= $urlOpen ?>"
        aria-label="Швидкий перегляд"
>
    <svg width="16px" height="16px">
        <use xlink:href="/images/sprite.svg#quickview-16"></use>
    </svg>
    <span class="fake-svg-icon"></span>
</button>
