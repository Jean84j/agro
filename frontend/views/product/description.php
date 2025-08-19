<?php

use common\models\shop\Product;
use kartik\rating\StarRating;
use yii\helpers\Url;
use yii\helpers\Html;

/** @var Product $product */
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
            <div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
                <div class="typography" id="product-description">
                    <h2 class="spec__header"><?= Yii::t('app', 'Опис, інструкція товару') . ' ' . $product->name ?></h2>
                    <div class="short-description"><?= $product->short_description ?></div>
                    <div class="full-description" style="display: none;"><?= $product->description ?></div>
                    <div class="footer-description"
                         style="display: none;"><?= $product->getFooterDescription($product->footer_description, $product->name) ?></div>
                    <button class="btn btn-secondary arrow-right"
                            id="show-more-btn"><?= Yii::t('app', 'Розгорнути опис') . $arrow ?></button>
                    <button class="btn btn-secondary arrow-left" id="hide-description-btn" style="display: none;">
                        <?= Yii::t('app', 'Приховати опис') . $arrow ?>
                    </button>
                </div>
            </div>
            <div class="product-tabs__pane" id="tab-analog">
                <div class="spec">
                    <h2 class="spec__header"><?= Yii::t('app', 'Аналог товару') . ' ' . $product->name ?></h2>
                    <?php if ($products_analog) { ?>
                        <div class="block-sidebar__item">
                            <div class="widget">
                                <div class="widget-products__list">
                                    <?php $i = 1;
                                    foreach ($products_analog as $product_analog): ?>
                                        <div class="products-view__list products-list" data-layout="list"
                                             data-with-features="false" data-mobile-grid-columns="2">
                                            <div class="products-list__body">
                                                <div class="products-list__item">
                                                    <div class="product-card product-card--hidden-actions ">
                                                        <?php if (isset($products_analog->label)): ?>
                                                            <div class="product-card__badges-list">
                                                                <div class="product-card__badge product-card__badge--new"><?= $products_analog->label->name ?></div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="product-card__image product-image">
                                                            <a href="<?= Url::to(['product/view', 'slug' => $product_analog->slug]) ?>"
                                                               class="product-image__body">
                                                                <img class="product-image__img"
                                                                     src="<?= $product_analog->getImgOneExtraLarge($product_analog->getId()) ?>"
                                                                     width="162" height="162"
                                                                     alt="<?= $product_analog->name ?>"
                                                                     loading="lazy">
                                                            </a>
                                                        </div>
                                                        <div class="product-card__info">
                                                            <div class="product-card__name">
                                                                <a href="<?= Url::to(['product/view', 'slug' => $product_analog->slug]) ?>"><?= $product_analog->name ?></a>
                                                            </div>
                                                            <div class="product-card__rating">
                                                                <div class="product-card__rating-stars">
                                                                    <div class="rating">
                                                                        <div class="rating__body">
                                                                            <?= $product_analog->getRating($product_analog->id, 13, 12) ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-card__rating-legend"><?= count($product_analog->reviews) ?>
                                                                    <?= Yii::t('app', 'відгуків') ?>
                                                                </div>
                                                            </div>
                                                            <ul class="product-card__features-list">
                                                                <?= Product::productParamsList($product_analog->id) ?>
                                                            </ul>
                                                        </div>
                                                        <div class="product-card__actions">
                                                            <div class="product-card__availability">
                                                                     <span class="text-success">
                                                                        <?= $this->render('@frontend/widgets/views/status', ['product' => $product_analog]) ?>
                                                                     </span>
                                                            </div>
                                                            <?php if ($product_analog->old_price == null) { ?>
                                                                <div class="product-card__prices">
                                                                    <?= Yii::$app->formatter->asCurrency($product_analog->getPrice()) ?>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="product-card__prices">
                                                                    <span class="widget-products__new-price"><?= Yii::$app->formatter->asCurrency($product_analog->getPrice()) ?></span>
                                                                    <span class="widget-products__old-price"><?= Yii::$app->formatter->asCurrency($product_analog->getOldPrice()) ?></span>
                                                                </div>
                                                            <?php } ?>
                                                            <?= $this->render('@frontend/widgets/views/add-to-cart-button.php', ['product' => $product_analog]) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++; endforeach ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
            <div class="product-tabs__pane" id="tab-specification">
                <div class="spec">
                    <h2 class="spec__header"><?= Yii::t('app', 'Характеристики') . ' ' . $product->name ?></h2>
                    <div class="spec__section">
                        <?= $this->render('properties', [
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
            <div class="product-tabs__pane" id="tab-faq">
                <div class="spec">
                    <h2 class="spec__header"><?= Yii::t('app', 'Часті запитання') ?></h2>
                    <div class="spec__section">
                        <?= $this->render('faq-accordion', [
                            'product_properties' => $product_properties,
                            'productId' => $product->id,
                            'language' => $language,
                            'faq' => $faq,
                        ]) ?>
                    </div>
                    <div class="spec__disclaimer">

                    </div>
                </div>
            </div>
            <div class="product-tabs__pane" id="tab-reviews">
                <div class="reviews-view">
                    <div class="reviews-view__list">
                        <?php if ($product->reviews): ?>
                            <?php if ($product->category->prefix) { ?>
                                <h2 class="reviews-view__header"><?= Yii::t('app', 'Відгуки про') ?>
                                    <?= $product->category->prefix ? '<span class="category-prefix">' . $product->category->prefix . '</span>' : '' ?>
                                    <?= $product->name ?>
                                </h2>
                            <?php } else { ?>
                                <h2 class="reviews-view__header"><?= $product->name ?></h2>
                            <?php } ?>
                        <?php endif; ?>
                        <div class="reviews-list">
                            <ol class="reviews-list__content">
                                <?php foreach ($product->reviews as $review):
                                    $rating = $review->rating;
                                    ?>
                                    <li class="reviews-list__item">
                                        <div class="review">
                                            <div class="review__avatar">
                                                <?php $avatar = $review->getAvatar($review->id) ?>
                                                <img src="/images/avatars/<?= $avatar ?>.jpg"
                                                     width="70" height="70"
                                                     alt="<?= $avatar ?>"
                                                     loading="lazy">
                                            </div>
                                            <div class="review__content">
                                                <div class="review__author"><?= Html::encode($review->name) ?></div>
                                                <div class="review__rating">
                                                    <div class="rating">
                                                        <div class="rating__body">
                                                            <?php if ($rating != 0): ?>
                                                                <?php for ($i = 1; $i <= $rating; $i++): ?>
                                                                    <svg class="rating__star rating__star--active"
                                                                         width="16px" height="15px">
                                                                        <g class="rating__fill">
                                                                            <use xlink:href="/images/sprite.svg#star-normal"></use>
                                                                        </g>
                                                                        <g class="rating__stroke">
                                                                            <use xlink:href="/images/sprite.svg#star-normal-stroke"></use>
                                                                        </g>
                                                                    </svg>
                                                                    <div class="rating__star rating__star--only-edge rating__star--active">
                                                                        <div class="rating__fill">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                        <div class="rating__stroke">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                    </div>
                                                                <?php endfor; ?>
                                                                <?php if (5 - $rating != 0): ?>
                                                                    <?php for ($i = 1; $i <= 5 - $rating; $i++): ?>
                                                                        <svg class="rating__star " width="16px"
                                                                             height="15px">
                                                                            <g class="rating__fill">
                                                                                <use xlink:href="/images/sprite.svg#star-normal"></use>
                                                                            </g>
                                                                            <g class="rating__stroke">
                                                                                <use xlink:href="/images/sprite.svg#star-normal-stroke"></use>
                                                                            </g>
                                                                        </svg>
                                                                        <div class="rating__star rating__star--only-edge ">
                                                                            <div class="rating__fill">
                                                                                <div class="fake-svg-icon"></div>
                                                                            </div>
                                                                            <div class="rating__stroke">
                                                                                <div class="fake-svg-icon"></div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endfor; ?>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                    <svg class="rating__star " width="16px"
                                                                         height="15px">
                                                                        <g class="rating__fill">
                                                                            <use xlink:href="/images/sprite.svg#star-normal"></use>
                                                                        </g>
                                                                        <g class="rating__stroke">
                                                                            <use xlink:href="/images/sprite.svg#star-normal-stroke"></use>
                                                                        </g>
                                                                    </svg>
                                                                    <div class="rating__star rating__star--only-edge ">
                                                                        <div class="rating__fill">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                        <div class="rating__stroke">
                                                                            <div class="fake-svg-icon"></div>
                                                                        </div>
                                                                    </div>
                                                                <?php endfor; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="review__text"><?= Html::encode($review->message) ?></div>
                                                <div class="review__date"><?= Yii::$app->formatter->asDate($review->created_at) ?></div>
                                                <?php if ($review->respond_message): ?>
                                                    <div class="pl-5">
                                                        <div class="review__admin mt-2"><?= Yii::t('app', 'Адміністратор AgroPro') ?></div>
                                                        <div class="review__text"><?= $review->respond_message ?></div>
                                                        <div class="review__date"><?= Yii::$app->formatter->asDate($review->created_at) ?></div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </div>
                    <form id="form-review">
                        <h3 class="reviews-view__header"><?= Yii::t('app', 'Залишити відгук') ?></h3>
                        <div class="row">
                            <div class="col-12 col-lg-9 col-xl-8">
                                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="w0"><?= Yii::t('app', 'Ваша оцінка') ?></label>
                                        <?php
                                        echo StarRating::widget([
                                            'name' => 'star_rating',
                                            'language' => 'uk',
                                            'value' => 5,
                                            'pluginOptions' => [
                                                'min' => 0,
                                                'max' => 5,
                                                'step' => 1,
                                                'size' => 'sm',
                                                'showClear' => false,
                                                'showCaption' => false,
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                    <div class="form-group col-md-4" id="url-review"
                                         data-url-review="<?= Yii::$app->urlManager->createUrl(['review/create']) ?>">
                                        <label for="review-name"><?= Yii::t('app', 'Ваше ім’я') ?></label>
                                        <input type="text" name="name" class="form-control" id="review-name"
                                               oninvalid="this.setCustomValidity('Укажіть будь ласка Ваше ім’я')"
                                               oninput="this.setCustomValidity('')"
                                               placeholder="<?= Yii::t('app', 'Ваше ім’я') ?>" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="review-email">Email</label>
                                        <input type="text" name="email" class="form-control" id="review-email"
                                               placeholder="Email"
                                               oninvalid="this.setCustomValidity('Укажіть будь ласка Ваш email')"
                                               oninput="this.setCustomValidity('')"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="review-text"><?= Yii::t('app', 'Ваш відгук') ?></label>
                                    <textarea class="form-control" name="message" id="review-text"
                                              placeholder="<?= Yii::t('app', 'Ваш відгук') ?>"
                                              rows="6"
                                              oninvalid="this.setCustomValidity('Напишіть будь ласка Ваш відгук')"
                                              oninput="this.setCustomValidity('')"
                                              required></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" id="review-form-submit" class="btn btn-primary btn-lg">
                                        <?= Yii::t('app', 'Залишити відгук') ?>
                                    </button>
                                    <div class="alert alert-success" style="display: none;" id="success-message"
                                         role="alert">
                                        <?= Yii::t('app', 'Вітаемо Ваш відгук -- надіслано') ?> !!!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="additional-text" style="display: none;"><?= $currentUrl ?></div>