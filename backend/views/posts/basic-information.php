<?php

use vova07\imperavi\Widget;

/** @var yii\web\View $this */
/** @var common\models\Posts $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="card">
    <div class="card-header">
        <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                                                class="mb-0 fs-exact-18"><?= Yii::t('app', 'Basic information') ?></h2></span>
        </div>
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link active"
                        id="description-tab-uk"
                        data-bs-toggle="tab"
                        data-bs-target="#description-tab-content-uk"
                        type="button"
                        role="tab"
                        aria-controls="description-tab-content-uk"
                        aria-selected="true"
                >
                    UK<span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <?php if (isset($translateRu)): ?>
                <li class="nav-item" role="presentation">
                    <button
                            class="nav-link"
                            id="description-tab-ru"
                            data-bs-toggle="tab"
                            data-bs-target="#description-tab-content-ru"
                            type="button"
                            role="tab"
                            aria-controls="description-tab-content-ru"
                            aria-selected="true"
                    >
                        RU<span class="nav-link-sa-indicator"></span>
                    </button>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div
                    class="tab-pane fade show active"
                    id="description-tab-content-uk"
                    role="tabpanel"
                    aria-labelledby="description-tab-uk"
            >
                <div class="card">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-8 mb-4">
                                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-4 mb-4">
                                <?php
                                if (!$model->isNewRecord) {
                                    $model->date_public = date('d-m-Y', $model->date_public);
                                    ?>
                                    <?= $form->field($model, 'date_public')->textInput() ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-8 mb-4">
                            <?php if ($model->isNewRecord) { ?>
                                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                            <?php } ?>
                        </div>
                        <div class="mb-4">
                            <?= $form->field($model, 'description')->widget(Widget::class, [
                                'options' => ['id' => 'uk-description'],
                                'defaultSettings' => [
                                    'style' => 'position: unset;'
                                ],
                                'settings' => [
                                    'lang' => 'uk',
                                    'minHeight' => 100,
                                    'plugins' => [
                                        'fullscreen',
                                        'table',
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div
                    class="tab-pane fade"
                    id="description-tab-content-ru"
                    role="tabpanel"
                    aria-labelledby="description-tab-ru"
            >
                <?php if (isset($translateRu)): ?>
                    <div class="card">
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col-8 mb-4">
                                    <?= $form->field($translateRu, 'title')->textInput(['maxlength' => true, 'id' => 'translateRu-title', 'name' => 'PostsTranslate[ru][title]']) ?>
                                </div>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($translateRu, 'description')->widget(Widget::class, [
                                    'options' => ['id' => 'translateRu-description', 'name' => 'PostsTranslate[ru][description]'],
                                    'defaultSettings' => [
                                        'style' => 'position: unset;'
                                    ],
                                    'settings' => [
                                        'lang' => 'uk',
                                        'minHeight' => 100,
                                        'plugins' => [
                                            'fullscreen',
                                            'table',
                                        ],
                                    ],
                                ]); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
