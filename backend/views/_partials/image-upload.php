<?php

use kartik\file\FileInput;

/** @var  $model */
/** @var  $header */
/** @var  $dir */
/** @var  $form */
/** @var  $file */

?>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <?= $this->render('/_partials/card-name-label', ['cardName' => $header]); ?>
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
