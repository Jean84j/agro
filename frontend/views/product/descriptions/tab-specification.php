<?php

/** @var  $product */
/** @var  $product_properties */
/** @var  $language */

?>
<div class="product-tabs__pane" id="tab-specification">
    <div class="spec">
        <h2 class="spec__header"><?= Yii::t('app', 'Характеристики') . ' ' . $product->name ?></h2>
        <div class="spec__section">
            <?= $this->render('/product/properties', [
                'product_properties' => $product_properties,
                'productId' => $product->id,
                'language' => $language,
            ]) ?>
        </div>
        <div class="spec__disclaimer">
            <?php if ($language == 'ru'): ?>
                Информация о технических характеристиках, комплекте поставки, стране производителя и внешнем виде товара является справочной и базируется на актуальной на момент публикации информации.
            <?php elseif ($language == 'en'): ?>
                Information about technical specifications, delivery package, country of manufacture and appearance of the product is for reference only and is based on information current at the time of publication.
            <?php else: ?>
                Інформація про характеристики, комплект поставки, країну виробника та зовнішній вигляд товару є довідковою та базується на актуальній на момент публікації інформації.
            <?php endif; ?>
        </div>
    </div>
</div>
