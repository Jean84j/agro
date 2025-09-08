<?php

use vova07\imperavi\Widget;

?>
<div class="card">
    <div class="card-body p-5">
        <?= $this->render('/_partials/card-name-label', ['cardName' => 'Basic information']); ?>
        <div class="row">
            <div class="mb-4 col-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
            </div>

            <div class="mb-4 col-6">
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            </div>
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
        <div class="tab-content">
            <div
                    class="tab-pane fade show active"
                    id="home-tab-content-2"
                    role="tabpanel"
                    aria-labelledby="home-tab-2"
            >
                <div class="card-body p-5">
                    <div class="mb-4">
                        <?= $form->field($model, 'page_description')->widget(Widget::class, [
                            'id' => 'page_description',
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
            <div
                    class="tab-pane fade"
                    id="profile-tab-content-2"
                    role="tabpanel"
                    aria-labelledby="profile-tab-2"
            >
                <?php if (isset($translateRu)): ?>
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <?= $form->field($translateRu, 'page_description')->widget(Widget::class, [
                                'options' => ['id' => 'translateRu-page_description', 'name' => 'SeoTranslate[ru][page_description]'],
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
