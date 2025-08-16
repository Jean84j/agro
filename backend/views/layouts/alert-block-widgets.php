<?php

use kartik\alert\AlertBlock;
use kartik\growl\Growl;

echo AlertBlock::widget([
    'type' => AlertBlock::TYPE_GROWL,
    'useSessionFlash' => true,
    'closeButton' => ['style' => 'display: none'],
    'alertSettings' => [
        'success' => [
            'type' => Growl::TYPE_SUCCESS,
            'icon' => 'fas fa-check-circle',
            'delay' => 100,
            'iconOptions' => ['class' => 'icon-options'],
            'bodyOptions' => ['class' => 'body-options'],
            'pluginOptions' => [
                'z_index' => 3031,
                'placement' => [
                    'from' => 'bottom',
                    'align' => 'right'
                ],
            ]
        ],
        'danger' => [
            'type' => Growl::TYPE_DANGER,
            'icon' => 'fas fa-check-circle',
            'iconOptions' => ['class' => 'icon-options'],
            'bodyOptions' => ['class' => 'body-options;'],
            'pluginOptions' => [
                'z_index' => 3031,
                'placement' => [
                    'from' => 'bottom',
                    'align' => 'right'
                ]
            ]
        ],
        'warning' => [
            'type' => Growl::TYPE_WARNING,
            'icon' => 'fas fa-check-circle',
            'iconOptions' => ['class' => 'icon-options'],
            'bodyOptions' => ['class' => 'body-options'],
            'pluginOptions' => [
                'z_index' => 3031,
                'placement' => [
                    'from' => 'bottom',
                    'align' => 'right'
                ]
            ]
        ],
        'info' => [
            'type' => Growl::TYPE_INFO,
            'icon' => 'fas fa-check-circle',
            'iconOptions' => ['class' => 'icon-options'],
            'bodyOptions' => ['class' => 'body-options'],
            'pluginOptions' => [
                'z_index' => 3031,
                'placement' => [
                    'from' => 'bottom',
                    'align' => 'right'
                ]
            ]
        ]
    ]
]);
?>
<style>
    .icon-options {
        font-size: 26px;
    }

    .body-options {
        font-size: 20px;
        font-weight: bold;
    }
</style>
