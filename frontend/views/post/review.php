<?php

use kartik\rating\StarRating;
use yii\helpers\Html;

?>
<div class="reviews-view">
    <div class="reviews-view__list">
        <?php if ($postItem->reviews) { ?>
            <h3 class="reviews-view__header"><?= Yii::t('app', 'Відгуки читачів') ?></h3>
        <?php } ?>
        <div class="reviews-list">
            <ol class="reviews-list__content">
                <?php foreach ($postItem->reviews as $review):
                    $rating = $review->rating;
                    ?>
                    <li class="reviews-list__item">
                        <div class="review">
                            <div class="review__avatar">
                                <?php $avatar = $review->getAvatar($review->id) ?>
                                <img src="/images/avatars/<?= $avatar ?>.jpg"
                                     width="70" height="70"
                                     alt="<?= $avatar ?>">
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
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>
<form id="form-review" data-url-review="<?= Yii::$app->urlManager->createUrl(['posts-review/create']) ?>">
    <h3 class="reviews-view__header"><?= Yii::t('app', 'Залишити відгук') ?></h3>
    <div class="row">
        <div class="col-12 col-lg-9 col-xl-8">
            <input type="hidden" name="post_id" value="<?= $postItem->id ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="w0"><?=Yii::t('app','Ваша оцінка')?></label>
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
                <div class="form-group col-md-4">
                    <label for="name"><?=Yii::t('app','Ваше ім’я')?></label>
                    <input type="text" name="name" class="form-control" id="name"
                           oninvalid="this.setCustomValidity('Вкажіть будь ласка Ваше ім’я'); this.reportValidity();"
                           oninput="this.setCustomValidity('')"
                           placeholder="<?=Yii::t('app','Ваше ім’я')?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">email</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="Email"
                           oninvalid="this.setCustomValidity('Вкажіть будь ласка Ваш email'); this.reportValidity();"
                           oninput="this.setCustomValidity('')"
                           required>
                </div>
            </div>
            <div class="form-group">
                <label for="review-text"><?=Yii::t('app','Ваш відгук')?></label>
                <textarea class="form-control" name="message" id="review-text"
                          placeholder="<?=Yii::t('app','Ваш відгук')?>"
                          rows="6"
                          oninvalid="this.setCustomValidity('Напишіть будь ласка Ваш відгук'); this.reportValidity();"
                          oninput="this.setCustomValidity('')"
                          required></textarea>
            </div>
            <div class="form-group mb-0">
                <button type="submit" id="review-form-submit" class="btn btn-primary btn-lg">
                    <?= Yii::t('app', 'Залишити відгук') ?>
                </button>
                <div class="alert alert-success" style="display: none;" id="success-message" role="alert">
                    <?= Yii::t('app', 'Вітаемо Ваш відгук -- надіслано !!!') ?>
                </div>
            </div>
        </div>
    </div>
</form>