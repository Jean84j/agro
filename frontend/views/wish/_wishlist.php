<?php
use yii\helpers\Url;

/** @var  $products */
/** @var  $properties */

if ($products) { ?>
    <div class="block">
        <div class="container">
            <table class="wishlist">
                <thead class="wishlist__head">
                <tr class="wishlist__row">
                    <th class="wishlist__column wishlist__column--image"><?= Yii::t('app', 'Зображення') ?></th>
                    <th class="wishlist__column wishlist__column--product"><?= Yii::t('app', 'Назва') ?></th>
                    <th class="wishlist__column wishlist__column--stock"><?= Yii::t('app', 'Наявність') ?></th>
                    <th class="wishlist__column wishlist__column--price"><?= Yii::t('app', 'Ціна') ?></th>
                    <th class="wishlist__column wishlist__column--tocart"></th>
                    <th class="wishlist__column wishlist__column--remove"></th>
                </tr>
                </thead>
                <tbody class="wishlist__body">
                <?php foreach ($products as $product): ?>
                    <tr class="wishlist__row">
                        <td class="wishlist__column wishlist__column--image">
                            <div class="product-image">
                                <a class="product-image__body"
                                   href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>">
                                    <img class="product-image__img"
                                         src="<?= $product->getImgOneLarge($product->getId()) ?>"
                                         width="80" height="80"
                                         alt="<?= $product->name ?>">
                                </a>
                            </div>
                        </td>
                        <td class="wishlist__column wishlist__column--product">
                            <?php if ($product->category->prefix) { ?>
                                <div class="product-card__name">
                                    <?php echo $product->category->prefix ? '<span class="category-prefix">' . $product->category->prefix . '</span>' : '' ?>
                                </div>
                            <?php } ?>
                            <div class="product-card__name">
                                <a href="<?= Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $product->name ?></a>
                            </div>
                            <div class="wishlist__product-rating">
                                <div class="rating">
                                    <?= $product->getRating($product->id, 13, 12) ?>
                                </div>
                                <div class="wishlist__product-rating-legend"><?= count($product->reviews) ?>
                                    <?= Yii::t('app', 'відгуків') ?>
                                </div>
                            </div>
                        </td>
                        <td class="wishlist__column wishlist__column--stock">
                            <?= $this->render('/_partials/status', ['product' => $product]) ?>
                        </td>
                        <td class="wishlist__column wishlist__column--price">
                            <?= $this->render('/_partials/price', ['product' => $product]) ?>
                        </td>
                        <td class="wishlist__column wishlist__column--tocart">
                            <?= $this->render('/_partials/add-to-cart-button', [
                                'product' => $product,
                                'buttonsVisible' => false
                            ]) ?>
                        </td>
                        <td class="wishlist__column wishlist__column--remove">
                            <button type="button"
                                    class="btn btn-light btn-sm btn-svg-icon"
                                    id="delete-from-wish-btn"
                                    data-url-wish="<?= Yii::$app->urlManager->createUrl(['wish/delete-from-wish']) ?>"
                                    data-wish-product-id="<?= $product->id ?>">
                                <svg width="12px" height="12px">
                                    <use xlink:href="/images/sprite.svg#cross-12"></use>
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>
    <div class="block">
        <div class="container">
            <div class="wishlist-not-products">
                <div class="wishlist-not-products__content">
                    <h2 class="wishlist-not-products__title"><?= Yii::t('app', 'Список бажань порожній!') ?></h2>
                    <p class="wishlist-not-products__text">
                        <?= Yii::t('app', 'Додайте товари до списку бажань.') ?>
                        <br>
                        <?= Yii::t('app', 'Спробуйте скористатися пошуком.') ?>
                    </p>
                    <img src="/images/no-wish.jpg" alt="Список бажань порожній">
                    <p class="wishlist-not-products__text">
                        <?= Yii::t('app', 'Або перейдіть на головну сторінку, щоб почати все спочатку.') ?>
                    </p>
                    <a class="btn btn-secondary btn-sm" href="/"><?= Yii::t('app', 'На Головну Сторінку') ?></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<style>
    .wishlist-not-products {
        text-align: center;
    }

    .wishlist-not-products__content {
        width: 480px;
        max-width: 100%;
        margin: 0 auto;
    }

    .wishlist-not-products__title {
        margin-bottom: 30px;
    }

    .wishlist-not-products__text {
        margin-bottom: 20px;
    }
</style>
