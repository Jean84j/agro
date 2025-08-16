<?php

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

/** @var yii\web\View $this */
/** @var common\models\SeoPages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(['options' => ['autocomplete' => "off"]]); ?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <nav class="mb-2" aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-sa-simple">
                                <?php
                                echo Breadcrumbs::widget([
                                    'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                                    'homeLink' => [
                                        'label' => 'Главная ',
                                        'url' => Yii::$app->homeUrl,
                                    ],
                                    'links' => $this->params['breadcrumbs'] ?? [],
                                ]);
                                ?>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-auto d-flex">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout"
                 data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
                <div class="sa-entity-layout__body">
                    <div class="sa-entity-layout__main">
                        <div class="card">
                            <div class="card-body p-5">
                                <div class="mb-5">
                                    <h2 class="mb-0 fs-exact-18">Основна інформація</h2>
                                </div>
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
                                                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                                            </div>
                                            <div class="mb-4">
                                                <?= $form->field($model, 'description')->widget(Widget::class, [
                                                    'id' => 'description',
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
                                                <div class="col-4 mb-4">
                                                    <?= $form->field($translateRu, 'title')->textInput(['maxlength' => true, 'id' => 'translateRu-title', 'name' => 'SeoTranslate[ru][title]'])->label(Yii::t('app', 'title')) ?>
                                                </div>
                                                <div class="mb-4">
                                                    <?= $form->field($translateRu, 'description')->widget(Widget::class, [
                                                        'options' => ['id' => 'translateRu-description', 'name' => 'SeoTranslate[ru][description]'],
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

