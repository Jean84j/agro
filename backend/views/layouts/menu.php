<?php

use common\models\Messages;
use common\models\PostsReview;
use backend\models\ReportReminder;
use common\models\shop\Order;
use common\models\shop\Review;
use yii\helpers\Url;

?>
<div class="sa-sidebar__body" data-simplebar="">
    <ul class="sa-nav sa-nav--sidebar" data-sa-collapse="">
        <!--   ------------------------------------------------------------>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/order']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#order"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Orders') ?></span>
                        <?php $orderNews = Order::orderNews() ?>
                        <?php if ($orderNews != 0) { ?>
                            <span class="sa-nav__menu-item-badge badge badge-new badge-sa-pill badge-sa-theme"><?= $orderNews ?></span>
                        <?php } ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/report']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                                <svg width="20px" height="20px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#report"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Report') ?></span>
                    </a>
                </li>
                <?php $event = ReportReminder::find()
                    ->where(['status' => 1])
                    ->orderBy(['date' => SORT_ASC])
                    ->one();

                if ($event !== null) {
                    $countEvents = ReportReminder::find()
                        ->where(['status' => 1])
                        ->count();

                    $currentDate = new DateTimeImmutable(date('Y-m-d'));
                    $eventDate = new DateTimeImmutable(date('Y-m-d', $event->date));
                    $days = (int)$currentDate->diff($eventDate)->format('%r%a');

                    // Цвет и анимация бейджа
                    $colors = [
                        -1 => ['badge-event-0day', 'badge-sa-theme-event-0day'],
                        0 => ['badge-event-0day', 'badge-sa-theme-event-0day'],
                        1 => ['badge-event-1day', 'badge-sa-theme-event-1day'],
                        2 => ['badge-event-2day', 'badge-sa-theme-event-2day'],
                    ];

                    [$eventBandageAnimColor, $eventBandageBackground] = $colors[$days] ?? ['', 'badge-sa-theme-event'];
                    $blinkClass = $days < 0 ? 'reminder-blink-red' : '';
                    $textReminderClass = $days < 0 ? 'text-reminder-red' : '';
                    ?>
                    <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                        <a href="<?= Url::to(['/report-reminder']) ?>" class="sa-nav__link">
                            <span class="sa-nav__icon <?= $blinkClass ?>">
                                <svg width="20px" height="20px" style="display: unset;">
                                    <use xlink:href="/admin/images/sprite.svg#tasks-admin"/>
                                </svg>
                            </span>
                                                <span class="sa-nav__title <?= $textReminderClass ?>">
                                <?= Yii::t('app', 'Reminder') ?>
                            </span>
                                                <span class="sa-nav__menu-item-badge badge
                                                <?= $eventBandageAnimColor ?> badge-sa-pill
                                                <?= $eventBandageBackground ?>">
                                <?= $countEvents ?>
                            </span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#statistic"/>
                                              </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Analytics Site') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/report-analytic']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#statistic"/>
                                              </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Analytics Report') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                    data-sa-collapse-item="sa-nav__menu-item--open">
                    <a href="" class="sa-nav__link" data-sa-collapse-trigger="">
                                            <span class="sa-nav__icon">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#categories"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Categories') ?></span>
                        <span class="sa-nav__arrow">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#arrow"/>
                                                </svg>
                                            </span>
                    </a>
                    <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content="">
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/category']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#star"/>
                                                </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'First') ?></span>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/auxiliary-categories']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#star"/>
                                                </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Second') ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/product']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#products"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Product') ?></span>
                    </a>
                </li>
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/order-provider']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                           <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#providers"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Providers') ?></span>
                    </a>
                </li>
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/label']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#labels"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Label') ?></span>
                    </a>
                </li>
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/grup']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                               <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#groups"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Group') ?></span>
                    </a>
                </li>
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/status']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#status"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Status') ?></span>
                    </a>
                </li>
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/tag']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                            <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#tags"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Tag') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/posts']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#posts"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Posts') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/slider']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#slider"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Slider') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/messages']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#messages"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Messages') ?></span>
                        <?php $messagesNews = Messages::messagesNews() ?>
                        <?php if ($messagesNews != 0) { ?>
                            <span class="sa-nav__menu-item-badge badge badge-new badge-sa-pill badge-sa-theme"><?= $messagesNews ?></span>
                        <?php } ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                    data-sa-collapse-item="sa-nav__menu-item--open">
                    <a href="" class="sa-nav__link" data-sa-collapse-trigger="">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#star"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Reviews') ?></span>
                        <?php $reviewsNews = Review::reviewsNews() ?>
                        <?php $reviewsPostNews = PostsReview::reviewsNews() ?>

                        <?php if ($reviewsNews != 0 || $reviewsPostNews != 0) { ?>
                            <span class="sa-nav__menu-item-badge badge badge-new badge-sa-pill badge-sa-theme"
                                  style="font-size: 16px">!</span>
                        <?php } else { ?>
                            <span class="sa-nav__arrow">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#arrow"/>
                                                </svg>
                                            </span>
                        <?php } ?>
                    </a>
                    <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content="">
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/review']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#star"/>
                                                </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Product Reviews') ?></span>
                                <?php if ($reviewsNews != 0) { ?>
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme"><?= $reviewsNews ?></span>
                                <?php } ?>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/posts-review']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#star"/>
                                                </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Posts Reviews') ?></span>
                                <?php if ($reviewsPostNews != 0) { ?>
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme"><?= $reviewsPostNews ?></span>
                                <?php } ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                    data-sa-collapse-item="sa-nav__menu-item--open">
                    <a href="" class="sa-nav__link" data-sa-collapse-trigger="">
                                            <span class="sa-nav__icon">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#users"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Active users') ?></span>
                        <span class="sa-nav__arrow">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#arrow"/>
                                                </svg>
                                            </span>
                    </a>
                    <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content="">
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/active-pages']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                                <svg width="20px" height="20px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#active-pages"/>
                                                </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Active users') ?></span>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/ip-bot']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                               <svg width="20px" height="20px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#users-sub"/>
                                                </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'IP Bot') ?></span>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/bots']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                                <svg width="20px" height="20px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#robot-bot"/>
                                                </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Name Bot') ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                    data-sa-collapse-item="sa-nav__menu-item--open">
                    <a href="" class="sa-nav__link" data-sa-collapse-trigger="">
                                            <span class="sa-nav__icon">
                                                <svg width="20px" height="20px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#setting"></use>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Settings') ?></span>
                        <span class="sa-nav__arrow">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#arrow"/>
                                                </svg>
                                            </span>
                    </a>
                    <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content="">
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/brand']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#brand"/>
                                              </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Brand') ?></span>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/properties-name']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#brand"/>
                                              </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Property name') ?></span>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/about']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#about"/>
                                              </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'About') ?></span>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/contact']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                            <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#contact"/>
                                              </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Contact') ?></span>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/seo-pages']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                            <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#seo-pages"/>
                                              </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Seo Pages') ?></span>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/delivery']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#delivery"/>
                                              </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Delivery') ?></span>
                            </a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                            <a href="<?= Url::to(['/translations']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#language"/>
                                              </svg>
                                            </span>
                                <span class="sa-nav__title"><?= Yii::t('app', 'Translations') ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
                <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                    <a href="<?= Url::to(['/minimum-order-amount']) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#slider"/>
                                                </svg>
                                            </span>
                        <span class="sa-nav__title"><?= Yii::t('app', 'Min sum order') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <!--   ------------------------------------------------------------>
        <li class="sa-nav__section">
            <ul class="sa-nav__menu sa-nav__menu--root">
            </ul>
        </li>
    </ul>
</div>
<style>
    .badge-new {
        animation: pulseOutlineYellow 2s infinite;
    }

    @keyframes pulseOutlineYellow {
        0% {
            box-shadow: 0 0 0 0 rgba(238, 211, 57, 0.94);
        }
        50% {
            box-shadow: 0 0 10px 6px rgba(229, 226, 73, 0.67);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 209, 100, 0.42);
        }
    }

    .badge-sa-theme-event {
        background: #727070;
        color: #0f0101;
    }

    .badge-sa-theme-event-2day {
        background: #73ee42;
        color: #0f0101;
    }

    .badge-event-2day {
        animation: pulseOutlineGreen 2s infinite;
    }

    @keyframes pulseOutlineGreen {
        0% {
            box-shadow: 0 0 0 0 rgba(64, 251, 2, 0.94);
        }
        50% {
            box-shadow: 0 0 10px 6px rgba(61, 194, 24, 0.67);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(121, 255, 100, 0.42);
        }
    }

    .badge-sa-theme-event-1day {
        background: #f4971d;
        color: #0f0101;
    }

    .badge-event-1day {
        animation: pulseOutlineOrange 2s infinite;
    }

    @keyframes pulseOutlineOrange {
        0% {
            box-shadow: 0 0 0 0 rgba(251, 105, 2, 0.94);
        }
        50% {
            box-shadow: 0 0 10px 6px rgba(194, 84, 24, 0.67);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 149, 100, 0.42);
        }
    }

    .badge-sa-theme-event-0day {
        background: #f50707;
        color: #0f0101;
    }

    .badge-event-0day {
        animation: pulseOutlineRed 2s infinite;
    }

    @keyframes pulseOutlineRed {
        0% {
            box-shadow: 0 0 0 0 rgba(251, 2, 2, 0.94);
        }
        50% {
            box-shadow: 0 0 10px 6px rgba(194, 24, 24, 0.67);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 100, 100, 0.42);
        }
    }

    .reminder-blink-red {
        animation: blinkRed 1s infinite;
        color: #f50707 !important;
        font-weight: 600;
        display: inline-block;
        transform-origin: center;
    }
    .text-reminder-red {
        color: #f50707 !important;
    }

    @keyframes blinkRed {
        0% {
            opacity: 0.3;
            transform: scale(1);
        }
        50% {
            opacity: 1;
            transform: scale(2);
        }
        100% {
            opacity: 0.3;
            transform: scale(1);
        }
    }
</style>