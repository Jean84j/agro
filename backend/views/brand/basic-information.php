<?php

use vova07\imperavi\Widget;

?>
<div class="card">
    <div class="card-header">
        <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Basic information') ?></h2></span>
        </div>
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="home-tab-2"
                    data-bs-toggle="tab"
                    data-bs-target="#home-tab-content-2"
                    type="button"
                    role="tab"
                    aria-controls="home-tab-content-2"
                    aria-selected="true"
                >
                    UK<span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <?php if (isset($translateRu)): ?>
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link"
                        id="profile-tab-2"
                        data-bs-toggle="tab"
                        data-bs-target="#profile-tab-content-2"
                        type="button"
                        role="tab"
                        aria-controls="profile-tab-content-2"
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
                id="home-tab-content-2"
                role="tabpanel"
                aria-labelledby="home-tab-2"
            >
                <div class="card">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-4 mb-4">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(Yii::t('app', 'name')) ?>
                            </div>
                            <div class="col-4 mb-4">
                                <?= $form->field($model, 'date_updated')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'value' => Yii::$app->formatter->asDatetime($model->date_updated),
                                    'readonly' => true,
                                ])->label(Yii::t('app', 'Date Updated')) ?>
                            </div>
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
                                        'fontcolor',
                                    ],
                                ],
                            ]); ?>
                        </div>
                        <div class="mb-4">
                            <?= $form->field($model, 'keywords')->textInput(['maxlength' => true])->label(Yii::t('app', 'keywords')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="profile-tab-content-2"
                role="tabpanel"
                aria-labelledby="profile-tab-2"
            >
                <div class="card">
                    <?php if (isset($translateRu)): ?>
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col-4 mb-4">
                                    <?= $form->field($translateRu, 'name')->textInput(['maxlength' => true, 'id' => 'translateRu-name', 'name' => 'BrandsTranslate[ru][name]'])->label(Yii::t('app', 'name')) ?>
                                </div>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($translateRu, 'description')->widget(Widget::class, [
                                    'options' => ['id' => 'translateRu-description', 'name' => 'BrandsTranslate[ru][description]'],
                                    'defaultSettings' => [
                                        'style' => 'position: unset;'
                                    ],
                                    'settings' => [
                                        'lang' => 'uk',
                                        'minHeight' => 100,
                                        'plugins' => [
                                            'fullscreen',
                                            'table',
                                            'fontcolor',
                                        ],
                                    ],
                                ]); ?>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($translateRu, 'keywords')->textInput(['maxlength' => true, 'id' => 'translateRu-keywords', 'name' => 'BrandsTranslate[ru][keywords]'])->label(Yii::t('app', 'keywords')) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
