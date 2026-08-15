<?php

use kartik\rating\StarRating;

/** @var  $postItem */

?>
<div class="reviews-view">
    <div class="reviews-view__list">
        <?php if ($postItem->reviews) { ?>
            <h3 class="reviews-view__header"><?= Yii::t('app', 'Відгуки читачів') ?></h3>
        <?php } ?>
        <div class="reviews-list">
            <?= $this->render('_review', ['postItem' => $postItem]) ?>
        </div>
    </div>
</div>
<form id="form-review" data-url-review="<?= Yii::$app->urlManager->createUrl(['post/create']) ?>">
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
                           oninvalid="this.setCustomValidity('Вкажіть будь ласка Ваше ім’я');"
                           oninput="this.setCustomValidity('')"
                           placeholder="<?=Yii::t('app','Як до вас звертатися')?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="email">email</label>
                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="<?=Yii::t('app','Ваша електронна пошта')?>"
                           oninvalid="this.setCustomValidity('Вкажіть будь ласка Ваш email');"
                           oninput="this.setCustomValidity('')"
                           required>
                </div>
            </div>
            <div class="form-group">
                <label for="review-text"><?=Yii::t('app','Ваш відгук')?></label>
                <textarea class="form-control" name="message" id="review-text"
                          placeholder="<?=Yii::t('app','Поділіться своїми враженнями про статтю...')?>"
                          rows="6"
                          oninvalid="this.setCustomValidity('Напишіть будь ласка Ваш відгук');"
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