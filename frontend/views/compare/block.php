<?php
use yii\helpers\Url;

/** @var  $products */
/** @var  $properties */

 if ($products) { ?>
    <div class="block">
        <div class="container">
            <div class="table-responsive">
                <table class="compare-table">
                    <tbody>
                    <tr>
                        <th><?=Yii::t('app','Продукт')?></th>
                        <?php foreach ($products as $product): ?>
                            <td>
                                <a class="compare-table__product-link"
                                   href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>">
                                    <div class="compare-table__product-image product-image">
                                        <div class="product-image__body">
                                            <img class="product-image__img"
                                                 src="<?= $product->getImgOneLarge($product->getId()) ?>"
                                                 width="131" height="131"
                                                 alt="<?= $product->name ?>">
                                        </div>
                                    </div>
                                    <?php if ($product->category->prefix) { ?>
                                        <div class="product-card__name">
                                            <?php echo $product->category->prefix ? '<span class="category-prefix">' . $product->category->prefix . '</span>' : '' ?>
                                        </div>
                                    <?php } ?>
                                    <div class="compare-table__product-name"><?= $product->name ?>
                                    </div>
                                </a>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th><?=Yii::t('app','Наявність')?></th>
                        <?php foreach ($products as $product): ?>
                            <td>
                                <?= $this->render('/_partials/status', ['product' => $product]) ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th><?=Yii::t('app','Ціна')?></th>
                        <?php foreach ($products as $product): ?>
                            <td>
                                <?= $this->render('/_partials/price', ['product' => $product]) ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th></th>
                        <?php foreach ($products as $product): ?>
                            <td>
                                <?php if ($product->status_id != 2) { ?>
                                    <button class="btn btn-primary btn-sm product-card__addtocart"
                                            type="button"
                                            data-status-btn="<?= Yii::t('app', 'В кошику') ?>"
                                            data-default-btn="<?= Yii::t('app', 'Купити') ?>"
                                            data-product-id="<?= $product->id ?>"
                                            data-url-cart-view="<?= Yii::$app->urlManager->createUrl(['cart/cart-view']) ?>"
                                            data-url-qty-cart="<?= Yii::$app->urlManager->createUrl(['cart/qty-cart']) ?>"
                                    >
                                        <svg width="20px" height="20px" style="display: unset;">
                                            <use xlink:href="/images/sprite.svg#cart-20"></use>
                                        </svg>
                                        <?= !$product->getIssetToCart($product->id) ? Yii::t('app','Купити') : Yii::t('app','В кошику') ?>
                                    </button>
                                <?php } else { ?>
                                    <button class="btn btn-secondary btn-sm disabled"
                                            type="button"
                                            data-product-id="<?= $product->id ?>">
                                        <svg width="20px" height="20px" style="display: unset;">
                                            <use xlink:href="/images/sprite.svg#cart-20"></use>
                                        </svg>
                                        <?= !$product->getIssetToCart($product->id) ? 'Купити' : 'В кошику' ?>
                                    </button>
                                <?php } ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <th></th>
                        <?php foreach ($products as $product): ?>
                            <td>
                                <button type="button"
                                        class="btn btn-dark btn-sm"
                                        id="delete-from-compare-btn"
                                        data-url-compare="<?= Yii::$app->urlManager->createUrl(['compare/delete-from-compare']) ?>"
                                        data-compare-product-id="<?= $product->id ?>">
                                    <i class="fas fa-trash-alt"></i> <?=Yii::t('app','Видалити')?>
                                </button>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($properties as $property): ?>
                        <tr>
                            <th style="background-color: rgba(252,231,3,0.3); font-weight: bold">
                                <?= $property['properties'] ?>
                            </th>
                            <?php foreach ($products as $product): ?>
                                <td>
                                    <?= $product->getCompareProperty($product->id, $property['property_id']) ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="block">
        <div class="container">
            <div class="compare-not-products">
                <div class="compare-not-products__content">
                    <h2 class="compare-not-products__title"><?=Yii::t('app','Список порівняння порожній!')?></h2>
                    <p class="compare-not-products__text">
                        <?=Yii::t('app','Додайте товари для порівняння.')?>
                        <br>
                        <?=Yii::t('app','Спробуйте скористатися пошуком.')?>
                    </p>
                    <img src="/images/no-compare.jpg" alt="Список порівняння порожній">
                    <p class="compare-not-products__text">
                        <?=Yii::t('app','Або перейдіть на головну сторінку, щоб почати все спочатку.')?>
                    </p>
                    <a class="btn btn-secondary btn-sm" href="/"><?=Yii::t('app','На Головну Сторінку')?></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<style>
    .compare-not-products {
        text-align: center;
    }
    .compare-not-products__content{
        width: 480px;
        max-width: 100%;
        margin: 0 auto;
    }
    .compare-not-products__title{
        margin-bottom: 30px;
    }
    .compare-not-products__text{
        margin-bottom: 20px;
    }
</style>
