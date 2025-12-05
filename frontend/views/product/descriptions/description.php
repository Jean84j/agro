<?php

use common\models\shop\Product;

/** @var Product $product */
/** @var  $mobile */
/** @var  $faq */
/** @var Product $products_analog_count */
/** @var Product $products_analog */
/** @var common\models\shop\ProductProperties $product_properties */

$request = Yii::$app->request;
$currentUrl = $request->absoluteUrl;

$rating = 3;

$arrow = '<span></span><span></span><span></span>';

$language = Yii::$app->language;

?>
<div class="product-tabs  product-tabs--sticky">
    <div class="product-tabs__list">
        <div class="product-tabs__list-body">
            <div class="product-tabs__list-container container">
                <a href="#tab-description"
                   class="product-tabs__item product-tabs__item--active"><?= Yii::t('app', 'Опис') ?></a>
                <?php if ($products_analog_count != null) : ?>
                    <a href="#tab-analog" class="product-tabs__item"><?= Yii::t('app', 'Аналог') ?> <span
                                class="indicator-analog__value"> <?= $products_analog_count ?></span></a>
                <?php endif; ?>
                <?php if ($mobile): ?>
                    <a href="#tab-specification"
                       class="product-tabs__item"><?= Yii::t('app', 'Характеристики') ?></a>
                <?php endif; ?>
                <?php if ($faq): ?>
                    <a href="#tab-faq" class="product-tabs__item"><?= Yii::t('app', 'Запитання') ?></a>
                <?php endif; ?>
                <a href="#tab-reviews" class="product-tabs__item"><?= Yii::t('app', 'Відгуки') ?></a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="product-tabs__content">
            <?= $this->render('tab-description', [
                'product' => $product,
                'arrow' => $arrow,
            ]) ?>

            <?= $this->render('tab-analog', [
                'products_analog' => $products_analog,
                'product' => $product,
                'language' => $language,
            ]) ?>

            <?= $this->render('tab-specification', [
                'product' => $product,
                'language' => $language,
                'product_properties' => $product_properties,
            ]) ?>

            <?= $this->render('tab-faq', [
                'faq' => $faq,
            ]) ?>

            <?= $this->render('tab-reviews', [
                'product' => $product,
            ]) ?>
        </div>
    </div>
</div>
<div id="additional-text" style="display: none;"><?= $currentUrl ?></div>