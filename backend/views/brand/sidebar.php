<?php

use kartik\file\FileInput;

?>
<div class="sa-entity-layout__sidebar">
    <div class="card w-100">
        <div class="card-body p-5">
            <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Image 340 x 80') ?></h2></span>
            </div>
            <div class="p-4 d-flex justify-content-center">
                <div class="max-w-20x">
                    <?php if ($model->isNewRecord): ?>
                        <?= $form->field($model, 'file')->widget(FileInput::class, [
                            'options' => ['accept' => 'image/*'],
                            'language' => 'uk',
                            'pluginOptions' => [
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => false,

                                'uploadLabel' => '',
                                'browseLabel' => '',
                                'removeLabel' => '',

                                'browseClass' => 'btn btn-success',
                                'uploadClass' => 'btn btn-info',
                                'removeClass' => 'btn btn-danger',
                                'removeIcon' => '<i class="fas fa-trash"></i> '
                            ]
                        ]); ?>
                    <?php else: ?>
                        <?php

                        echo $form->field($model, 'file')->widget(FileInput::class, [
                            'options' => ['accept' => 'image/*'],
                            'language' => 'uk',
                            'pluginOptions' => [
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
                                'initialPreview' => [
                                    Yii::$app->request->hostInfo . '/images/brand/' . $model->file
                                ],
                                'initialPreviewAsData' => true,
                            ]
                        ]);
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
