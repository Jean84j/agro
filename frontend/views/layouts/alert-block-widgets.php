<?php

use kartik\alert\AlertBlock;
use kartik\growl\Growl;
use kartik\growl\GrowlAsset;

GrowlAsset::register($this)->addTheme('growl');

$placementFrom = 'top';
$placementAlign = 'left';

if (Yii::$app->devicedetect->isMobile()){
    $placementFrom = 'bottom';
    $placementAlign = 'center';
}

echo AlertBlock::widget([
    'type' => AlertBlock::TYPE_GROWL,
    'useSessionFlash' => true,
    'alertSettings' => [

        'login' => [
            'type' => 'login',
            'icon' => 'fas fa-check-circle',
            'title' => ' LogIn!',
            'showSeparator' => true,
            'linkOptions' => ['style' => 'display:none;'],
            'pluginOptions' => [
                'delay' => 3000,
                'z_index' => 3031,
                'placement' => [
                    'from' => $placementFrom,
                    'align' => $placementAlign
                ],
            ]
        ],

        'logout' => [
            'type' => 'logout',
            'icon' => 'fas fa-check-circle',
            'title' => ' LogOut!',
            'showSeparator' => true,
            'linkOptions' => ['style' => 'display:none;'],
            'pluginOptions' => [
                'delay' => 3000,
                'z_index' => 3031,
                'placement' => [
                    'from' => $placementFrom,
                    'align' => $placementAlign
                ],
            ]
        ],

        'signup' => [
            'type' => 'signup',
            'icon' => 'fas fa-check-circle',
            'title' => 'Register Success!',
            'showSeparator' => true,
            'linkOptions' => ['style' => 'display:none;'],
            'pluginOptions' => [
                'delay' => 30000,
                'z_index' => 3031,
                'placement' => [
                    'from' => $placementFrom,
                    'align' => $placementAlign
                ],
            ]
        ],


        'passwordReset' => [
            'type' => 'signup',
            'icon' => 'fas fa-check-circle',
            'title' => 'Password Reset!',
            'showSeparator' => true,
            'linkOptions' => ['style' => 'display:none;'],
            'pluginOptions' => [
                'delay' => 30000,
                'z_index' => 3031,
                'placement' => [
                    'from' => $placementFrom,
                    'align' => $placementAlign
                ],
            ]
        ],

        'verificationEmail' => [
            'type' => 'signup',
            'icon' => 'fas fa-check-circle',
            'title' => 'Verification Email!',
            'showSeparator' => true,
            'linkOptions' => ['style' => 'display:none;'],
            'pluginOptions' => [
                'delay' => 30000,
                'z_index' => 3031,
                'placement' => [
                    'from' => $placementFrom,
                    'align' => $placementAlign
                ],
            ]
        ],

        'verifyEmail' => [
            'type' => 'signup',
            'icon' => 'fas fa-check-circle',
            'title' => 'Verify Email!',
            'showSeparator' => true,
            'linkOptions' => ['style' => 'display:none;'],
            'pluginOptions' => [
                'delay' => 30000,
                'z_index' => 3031,
                'placement' => [
                    'from' => $placementFrom,
                    'align' => $placementAlign
                ],
            ]
        ],

        'success' => [
            'type' => Growl::TYPE_SUCCESS,
            'icon' => 'fas fa-check-circle',
            'title' => 'LogIn!',
            'linkOptions' => ['style' => 'display:none;'],
            'showSeparator' => true,
            'pluginOptions' => [
                'delay' => 3000,
                'z_index' => 3031,
                'placement' => [
                    'from' => $placementFrom,
                    'align' => $placementAlign
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
                    'align' => $placementAlign
                ]
            ]
        ],
        'warning' => [
            'type' => Growl::TYPE_WARNING,
            'icon' => 'fas fa-check-circle',
            'title' => 'LogOut!',
            'linkOptions' => ['style' => 'display:none;'],
            'showSeparator' => true,
            'pluginOptions' => [
                'z_index' => 3031,
                'placement' => [
                    'from' => $placementFrom,
                    'align' => $placementAlign
                ]
            ]
        ],
        'info' => [
            'type' => Growl::TYPE_INFO,
            'icon' => 'fas fa-bell',
            'title' => 'Info',
            'showSeparator' => true,
            'linkOptions' => ['style' => 'display:none;'],
            'pluginOptions' => [
                'delay' => 5000,
                'z_index' => 3031,
                'placement' => [
                    'from' => $placementFrom,
                    'align' => $placementAlign
                ]
            ]
        ]
    ]
]);
?>
<style>

    [data-notify="container"].alert-login {
        background-color: rgb(43, 201, 19);
        border-color: #2ecc71;
    }

    [data-notify="container"].alert-login [data-notify="icon"] {
        color: #fff;
    }

    [data-notify="container"].alert-login [data-notify="title"] {
        color: #fff;
    }

    [data-notify="container"].alert-login [data-notify="message"] {
        color: #fff;
    }


    [data-notify="container"].alert-logout {
        background-color: rgb(249, 97, 3);
        border-color: #f40404;
    }

    [data-notify="container"].alert-logout [data-notify="icon"] {
        color: #fff;
    }

    [data-notify="container"].alert-logout [data-notify="title"] {
        color: #fff;
    }

    [data-notify="container"].alert-logout [data-notify="message"] {
        color: #fff;
    }


    [data-notify="container"].alert-signup {
        background-color: rgb(3, 183, 249);
        border-color: #04e8f4;
    }

    [data-notify="container"].alert-signup [data-notify="icon"] {
        color: #fff;
    }

    [data-notify="container"].alert-signup [data-notify="title"] {
        color: #fff;
    }

    [data-notify="container"].alert-signup [data-notify="message"] {
        color: #fff;
    }
</style>
