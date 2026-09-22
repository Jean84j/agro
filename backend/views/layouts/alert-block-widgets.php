<?php

use kartik\alert\AlertBlock;
use kartik\growl\Growl;
use kartik\growl\GrowlAsset;

GrowlAsset::register($this)->addTheme('growl');

echo AlertBlock::widget([
    'type' => AlertBlock::TYPE_GROWL,
    'useSessionFlash' => true,
    'alertSettings' => [


        'errorsDelete' => [
            'type' => 'errors-delete',
            'icon' => 'fas fa-check-circle',
            'linkOptions' => ['style' => 'display:none;'],
            'pluginOptions' => [
                'delay' => 4000,
                'z_index' => 3031,
                'placement' => [
                    'from' => 'bottom',
                    'align' => 'right'
                ],
            ]
        ],


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


    [data-notify="container"].alert-errors-delete {
        background-color: rgba(254, 1, 1, 0.5);
        border: 2px solid rgba(254, 3, 154, 0.99);
    }

    [data-notify="container"].alert-errors-delete [data-notify="icon"],
    [data-notify="container"].alert-errors-delete [data-notify="message"] {
        color: #fff;
        font-weight: bold;
        font-size: 18px;
    }
</style>
