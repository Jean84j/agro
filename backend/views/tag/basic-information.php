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
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-10">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(Yii::t('app', 'name')) ?>
                                </div>
                                <div class="col-2">
                                    <?= $form->field($model, 'visibility')->dropDownList([
                                        1 => Yii::t('app', 'Так'),
                                        0 => Yii::t('app', 'Ні'),
                                    ], [
                                        'id' => 'visibility-dropdown',
                                    ])->label(Yii::t('app', 'visibility')) ?>
                                    <?php
                                    $this->registerJs("
                                                                                    function updateBackgroundColor() {
                                                                                        var selectedValue = $('#visibility-dropdown').val();
                                                                                        if (selectedValue == 1) {
                                                                                            $('#visibility-dropdown').css('background-color', 'rgb(71 237 56 / 70%)');
                                                                                        } else if (selectedValue == 0) {
                                                                                            $('#visibility-dropdown').css('background-color', 'rgb(255 105 105 / 70%)');
                                                                                        } 
                                                                                    }
                                                                                    $(document).ready(function() {
                                                                                        updateBackgroundColor();
                                                                                    });
                                                                                    $('#visibility-dropdown').on('change', function() {
                                                                                        updateBackgroundColor();
                                                                                    });
                                                                                  ");
                                    ?>
                                </div>
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
                                    <?= $form->field($translateRu, 'name')->textInput(['maxlength' => true, 'id' => 'translateRu-name', 'name' => 'Translate[ru][name]'])->label(Yii::t('app', 'name')) ?>
                                </div>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($translateRu, 'description')->widget(Widget::class, [
                                    'options' => ['id' => 'translateRu-description', 'name' => 'Translate[ru][description]'],
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
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>