<?php

use common\models\Messages;
use common\models\PostsReview;
use backend\models\ReportReminder;
use common\models\shop\Order;
use common\models\shop\Review;
use common\models\SiteErrors;
use yii\helpers\Url;

$orderNews = Order::orderNews();

$event = ReportReminder::find()
    ->where(['status' => 1])
    ->orderBy(['date' => SORT_ASC])
    ->one();

$messagesNews = Messages::messagesNews();

$reviewsNews = Review::reviewsNews();
$reviewsPostNews = PostsReview::reviewsNews();

$countErrors = SiteErrors::find()->count();

$menuSections = [
    '0' => [
        'order' => [
            'url' => '/order',
            'icon' => '<span style="font-size: 22px">🛒</span>',
            'title' => 'Orders',
            'badge' => $orderNews,
        ],
    ],
    '1' => [
        'report' => [
            'url' => '/report',
            'icon' => '<span style="font-size: 22px">📂</span>',
            'title' => 'Report',
            'reminder' => 1,
        ],
    ],
    '2' => [
        'statistic' => [
            'url' => '/',
            'icon' => '<span style="font-size: 22px">📉</span>',
            'title' => 'Analytics Site',
        ],
    ],
    '3' => [
        'statisticReport' => [
            'url' => '/report-analytic',
            'icon' => '<span style="font-size: 22px">📈</span>',
            'title' => 'Analytics Report',
        ],
    ],
    '4' => [
        'categories' => [
            'url' => null,
            'icon' => '<span style="font-size: 22px">🗃️</span>',
            'title' => 'Categories',
            'subItems' => [
                'primeCategories' => [
                    'url' => '/category',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#star"/>
                                                </svg>',
                    'title' => 'First',
                ],
                'auxiliaryCategories' => [
                    'url' => '/auxiliary-categories',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#star"/>
                                                </svg>',
                    'title' => 'Second',
                ],
            ],
        ],
        'products' => [
            'url' => '/product',
            'icon' => '<span style="font-size: 22px">🛢️</span>',
            'title' => 'Product',
        ],
        'providers' => [
            'url' => '/order-provider',
            'icon' => '<span style="font-size: 22px">🤝</span>',
            'title' => 'Providers',
        ],
        'labels' => [
            'url' => '/label',
            'icon' => '<span style="font-size: 22px">🔖</span>',
            'title' => 'Label',
        ],
        'groups' => [
            'url' => '/grup',
            'icon' => '<span style="font-size: 22px">🗂️</span>',
            'title' => 'Group',
        ],
        'status' => [
            'url' => '/status',
            'icon' => '<span style="font-size: 22px">📌</span>',
            'title' => 'Status',
        ],
        'tags' => [
            'url' => '/tag',
            'icon' => '<span style="font-size: 22px">🏷️</span>',
            'title' => 'Tag',
        ],
    ],
    '5' => [
        'posts' => [
            'url' => '/posts',
            'icon' => '<span style="font-size: 22px">📝</span>',
            'title' => 'Posts',
        ],
    ],
    '6' => [
        'slider' => [
            'url' => '/slider',
            'icon' => '<span style="font-size: 22px">🖼️</span>',
            'title' => 'Slider',
        ],
    ],
    '7' => [
        'messages' => [
            'url' => '/messages',
            'icon' => '<span style="font-size: 22px">📧</span>',
            'title' => 'Messages',
            'message' => $messagesNews,
        ],
    ],
    '8' => [
        'reviews' => [
            'url' => null,
            'icon' => '<span style="font-size: 22px">⭐</span>',
            'title' => 'Reviews',
            'newReviews' => 1,
            'subItems' => [
                'product' => [
                    'url' => '/review',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#star"/>
                                                </svg>',
                    'title' => 'Product Reviews',
                    'newProductReview' => 1,
                ],
                'posts' => [
                    'url' => '/posts-review',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#star"/>
                                                </svg>',
                    'title' => 'Posts Reviews',
                    'newPostReview' => 1,
                ],
            ],
        ],
    ],
    '9' => [
        'activeUsers' => [
            'url' => null,
            'icon' => '<span style="font-size: 22px">🤓</span>',
            'title' => 'Active users',
            'subItems' => [
                'activePages' => [
                    'url' => '/active-pages',
                    'icon' => '<span style="font-size: 22px">😎</span>',
                    'title' => 'Active users',
                ],
                'siteErrors' => [
                    'url' => '/site-errors',
                    'icon' => '<span style="font-size: 22px">👿</span>',
                    'title' => 'Site Errors',
                    'newErrors' => 1,
                ],
                'ipBot' => [
                    'url' => '/ip-bot',
                    'icon' => '<span style="font-size: 22px">👾</span>',
                    'title' => 'IP Bot',
                ],
                'bots' => [
                    'url' => '/bots',
                    'icon' => '<span style="font-size: 22px">🤖</span>',
                    'title' => 'Name Bot',
                ],
            ],
        ],
    ],
    '10' => [
        'settings' => [
            'url' => null,
            'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#setting"/>
                                                </svg>',
            'title' => 'Settings',
            'subItems' => [
                'searchWords' => [
                    'url' => '/search-words',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#search"/>
                                                </svg>',
                    'title' => 'Search word',
                ],
                'brand' => [
                    'url' => '/brand',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#brand"/>
                                                </svg>',
                    'title' => 'Brand',
                ],
                'propertiesName' => [
                    'url' => '/properties-name',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#brand"/>
                                                </svg>',
                    'title' => 'Property name',
                ],
                'about' => [
                    'url' => '/about',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#about"/>
                                                </svg>',
                    'title' => 'About',
                ],
                'contact' => [
                    'url' => '/contact',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#contact"/>
                                                </svg>',
                    'title' => 'Contact',
                ],
                'seoPages' => [
                    'url' => '/seo-pages',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#seo-pages"/>
                                                </svg>',
                    'title' => 'Seo Pages',
                ],
                'delivery' => [
                    'url' => '/delivery',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#delivery"/>
                                                </svg>',
                    'title' => 'Delivery',
                ],
                'translations' => [
                    'url' => '/translations',
                    'icon' => '<svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#language"/>
                                                </svg>',
                    'title' => 'Translations',
                ],
            ],
        ],
    ],
    '11' => [
        'minimumOrderAmount' => [
            'url' => '/minimum-order-amount',
            'icon' => '<span style="font-size: 22px">💸</span>',
            'title' => 'Min sum order',
        ],
    ],
    '12' => [
        'sticker' => [
            'url' => '/sticker',
            'icon' => '<span style="font-size: 22px">🌼</span>',
            'title' => 'Stickers',
        ],
    ],
];

?>
<div class="sa-sidebar__body" data-simplebar="">
    <ul class="sa-nav sa-nav--sidebar" data-sa-collapse="">
        <!--   ------------------------------------------------------------>
        <?php foreach ($menuSections as $menuSection): ?>
            <li class="sa-nav__section">
                <ul class="sa-nav__menu sa-nav__menu--root">
                    <?php foreach ($menuSection as $menuItem): ?>
                        <?php if ($menuItem['url'] == null): ?>
                            <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                                data-sa-collapse-item="sa-nav__menu-item--open">
                                <a href="" class="sa-nav__link" data-sa-collapse-trigger="">
                                            <span class="sa-nav__icon">
                                                <?= $menuItem['icon'] ?>
                                            </span>
                                    <span class="sa-nav__title"><?= Yii::t('app', $menuItem['title']) ?></span>
                                    <?php if (isset($menuItem['newReviews']) && ($reviewsNews != 0 || $reviewsPostNews != 0)) : ?>
                                        <span class="sa-nav__menu-item-badge badge badge-new badge-sa-pill badge-sa-theme"
                                              style="font-size: 16px">!</span>
                                    <?php else : ?>
                                        <span class="sa-nav__arrow">
                                                <svg width="16px" height="16px" style="display: unset;">
                                                 <use xlink:href="/admin/images/sprite.svg#arrow"/>
                                                </svg>
                                            </span>
                                    <?php endif; ?>
                                </a>
                                <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content="">
                                    <?php foreach ($menuItem['subItems'] as $subItem): ?>
                                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                                            <a href="<?= Url::to([$subItem['url']]) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                              <?= $subItem['icon'] ?>
                                            </span>
                                                <span class="sa-nav__title"><?= Yii::t('app', $subItem['title']) ?></span>
                                                <?php if (isset($subItem['newProductReview']) && $reviewsNews != 0) { ?>
                                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme"><?= $reviewsNews ?></span>
                                                <?php } ?>
                                                <?php if (isset($subItem['newPostReview']) && $reviewsPostNews != 0) { ?>
                                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme"><?= $reviewsPostNews ?></span>
                                                <?php } ?>
                                                <?php if (isset($subItem['newErrors']) && $countErrors != 0) { ?>
                                                    <span class="sa-nav__menu-item-badge badge badge-new badge-sa-pill badge-sa-theme"><?= $countErrors ?></span>
                                                <?php } ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="sa-nav__menu-item sa-nav__menu-item--has-icon">
                                <a href="<?= Url::to([$menuItem['url']]) ?>" class="sa-nav__link">
                                            <span class="sa-nav__icon">
                                                <?= $menuItem['icon'] ?>
                                            </span>
                                    <span class="sa-nav__title"><?= Yii::t('app', $menuItem['title']) ?></span>
                                    <?php if (isset($menuItem['badge']) && $orderNews != 0) { ?>
                                        <span class="sa-nav__menu-item-badge badge badge-new badge-sa-pill badge-sa-theme"><?= $orderNews ?></span>
                                    <?php } ?>
                                    <?php if (isset($menuItem['message']) && $messagesNews != 0) { ?>
                                        <span class="sa-nav__menu-item-badge badge badge-new badge-sa-pill badge-sa-theme"><?= $messagesNews ?></span>
                                    <?php } ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php
                        if (isset($menuItem['reminder'])) {
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
                            <?php }
                        } ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
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