<?php

use vova07\imperavi\Widget;

/**
 * Рендер поля с редактором
 */
function renderEditor($form, $model, $attribute, $id, $name = null, $clips = [])
{
    return $form->field($model, $attribute)->widget(Widget::class, [
        'options' => array_filter([
            'id' => $id,
            'name' => $name,
        ]),
        'defaultSettings' => [
            'style' => 'position: unset;',
        ],
        'settings' => [
            'lang' => 'uk',
            'minHeight' => 100,
            'plugins' => [
                'table',
                'fontcolor',
                'clips',
                'fullscreen',
            ],
            'clips' => $clips,
        ],
    ]);
}

// Общие заготовки
$clips = [[
    'All h3 Descr...', '
        <h3>Переваги використання</h3><p>-------------------</p>
        <h3>Механізм дії</h3><p>-------------------</p>
        <h3>Спосіб застосування, інструкція для</h3><p>-------------------</p>
        <h3>Норма витрат препарату</h3><p>-------------------</p>
        <h3>Рекомендації по застосуванню</h3><p>-------------------</p>
    '
]];
?>

<div class="card">
    <div class="card-body p-5">
        <div class="mb-5">
            <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart">
                <h2 class="mb-0 fs-exact-18">Основна інформація</h2>
            </span>
        </div>
        <div class="card">
            <div class="card-header card-background_color-basic">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="uk-tab-2" data-bs-toggle="tab"
                                data-bs-target="#uk-tab-content-2" type="button" role="tab"
                                aria-controls="uk-tab-content-2" aria-selected="true">
                            UK<span class="nav-link-sa-indicator"></span>
                        </button>
                    </li>
                    <?php if (isset($translateRu)): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ru-tab-2" data-bs-toggle="tab"
                                    data-bs-target="#ru-tab-content-2" type="button" role="tab"
                                    aria-controls="ru-tab-content-2" aria-selected="true">
                                RU<span class="nav-link-sa-indicator"></span>
                            </button>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="card-body card-background_color-basic">
                <div class="tab-content">
                    <!-- UK -->
                    <div class="tab-pane fade show active" id="uk-tab-content-2" role="tabpanel"
                         aria-labelledby="uk-tab-2">
                        <div class="mb-4 card card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                                </div>
                                <?php if (!$model->isNewRecord): ?>
                                    <?php foreach (['date_public', 'date_updated'] as $field): ?>
                                        <div class="col-md-3 mb-4">
                                            <?= $form->field($model, $field)->textInput([
                                                'maxlength' => true,
                                                'class' => 'form-control',
                                                'value' => Yii::$app->formatter->asDatetime($model->$field),
                                                'readonly' => true,
                                            ]) ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-md-6 mb-4">
                                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-4 card card-body">
                            <?= renderEditor($form, $model, 'short_description', 'uk-short_description') ?>
                        </div>
                        <div class="mb-4 card card-body">
                            <?= renderEditor($form, $model, 'description', 'uk-description', null, $clips) ?>
                        </div>
                        <?php if (!$model->isNewRecord): ?>
                            <div class="mb-4 card card-body">
                                <?= renderEditor($form, $model, 'footer_description', 'uk-footer_description') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- RU -->
                    <?php if (isset($translateRu)): ?>
                        <div class="tab-pane fade" id="ru-tab-content-2" role="tabpanel" aria-labelledby="ru-tab-2">
                            <div class="mb-4 card card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <?= $form->field($translateRu, 'name')->textInput([
                                            'maxlength' => true,
                                            'class' => 'form-control',
                                            'id' => 'translateRu-name',
                                            'name' => 'Translate[ru][name]',
                                        ]) ?>
                                    </div>
                                    <?php foreach (['date_public', 'date_updated'] as $field): ?>
                                        <div class="col-md-3 mb-4">
                                            <?= $form->field($translateRu, $field)->textInput([
                                                'id' => "translateRu-$field",
                                                'name' => "Translate[ru][$field]",
                                                'maxlength' => true,
                                                'class' => 'form-control',
                                                'value' => Yii::$app->formatter->asDatetime($model->$field),
                                                'readonly' => true,
                                            ]) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="mb-4 card card-body">
                                <?= renderEditor($form, $translateRu, 'short_description', 'ru-short_description', 'Translate[ru][short_description]') ?>
                            </div>
                            <div class="mb-4 card card-body">
                                <?= renderEditor($form, $translateRu, 'description', 'ru-description', 'Translate[ru][description]', $clips) ?>
                            </div>
                            <?php if (!$model->isNewRecord): ?>
                                <div class="mb-4 card card-body">
                                    <?= renderEditor($form, $translateRu, 'footer_description', 'ru-footer_description', 'Translate[ru][footer_description]') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card-background_color-basic {
        background-color: #ff008417;
    }
    .redactor-editor{
       background-color: #ffec5542;
    }
    .redactor-toolbar {
        background-color: #ffe95bab;
    }
</style>