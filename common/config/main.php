<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    // 'bootstrap' => ['assetsAutoCompress'],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'cart' => [
            'class' => 'yz\shoppingcart\ShoppingCart',
            'cartId' => 'agro_cart',
        ],
    ],
];
