<?php

use kartik\file\FileInput;

?>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
            <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart">
                <h2 class="mb-0 fs-exact-18"><?= Yii::t('app', $header) ?></h2>
            </span>
        </div>
        <div class="p-4 d-flex justify-content-center">
            <div class="max-w-20x">
                <?php
                $pluginOptions = [
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false,

                    'uploadLabel' => '',
                    'browseLabel' => '',
                    'removeLabel' => '',

                    'browseClass' => 'btn btn-success',
                    'uploadClass' => 'btn btn-info',
                    'removeClass' => 'btn btn-danger',
                    'removeIcon' => '<i class="fas fa-trash"></i> ',
                ];

                if (!$model->isNewRecord) {
                    $pluginOptions['initialPreview'] = [$dir];
                    $pluginOptions['initialPreviewAsData'] = true;
                }

                echo $form->field($model, $file)->widget(FileInput::class, [
                    'options' => ['accept' => 'image/*'],
                    'language' => 'uk',
                    'pluginOptions' => $pluginOptions,
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
