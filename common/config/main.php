<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    // 'bootstrap' => ['assetsAutoCompress'],2222222222222222222222222222222
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
