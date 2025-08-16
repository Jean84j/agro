<?php

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

/** @var yii\web\View $this */
/** @var common\models\shop\Brand $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container container--max--xl" style="max-width: 1623px">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <nav class="mb-2" aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-sa-simple">
                                <?php echo Breadcrumbs::widget([
                                    'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                                    'homeLink' => [
                                        'label' => Yii::t('app', 'Home'),
                                        'url' => Yii::$app->homeUrl,
                                    ],
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]);
                                ?>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-auto d-flex">
                        <?php if (!$model->isNewRecord): ?>
                            <?= Html::a(Yii::t('app', 'List Brands'), Url::to(['index']), ['class' => 'btn btn-secondary me-3']) ?>
                            <?= Html::a(Yii::t('app', 'Create more'), Url::to(['create']), ['class' => 'btn btn-success me-3']) ?>
                        <?php endif; ?>
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout"
                 data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
                <div class="sa-entity-layout__body">
                    <div class="sa-entity-layout__main">
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
                        <div class="card mt-5">
                            <div class="card-header">
                                <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                                                class="mb-0 fs-exact-18"><?= Yii::t('app', 'Search engine optimization') ?></h2></span>
                                    <div class="mt-3 text-muted">
                                        <?= Yii::t('app', 'Provide information that will help improve the snippet and bring your category to the top of search engines.') ?>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button
                                                class="nav-link active"
                                                id="uk-seo-2"
                                                data-bs-toggle="tab"
                                                data-bs-target="#uk-seo-content-2"
                                                type="button"
                                                role="tab"
                                                aria-controls="uk-tab-content-2"
                                                aria-selected="true"
                                        >
                                            UK<span class="nav-link-sa-indicator"></span>
                                        </button>
                                    </li>
                                    <?php if (isset($translateRu)): ?>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                    class="nav-link"
                                                    id="ru-seo-2"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#ru-seo-content-2"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="ru-seo-content-2"
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
                                            id="uk-seo-content-2"
                                            role="tabpanel"
                                            aria-labelledby="uk-seo-2">
                                        <div class="card">
                                            <div class="card-body p-5">
                                                <div class="mb-4">
                                                    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true, 'id' => 'seo_title_id'])->label('SEO Тайтл' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountTitle" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 55 < 60"> 0</label>') ?>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            var textLength = $('#seo_title_id').val().length;
                                                            $('#charCountTitle').text(textLength);
                                                            if (textLength === 55) {
                                                                $('#charCountTitle').css('background-color', '#13bf3d87');
                                                            } else if (textLength >= 50 && textLength <= 54) {
                                                                $('#charCountTitle').css('background-color', '#eded248c');
                                                            } else if (textLength >= 56 && textLength <= 60) {
                                                                $('#charCountTitle').css('background-color', '#eded248c');
                                                            } else {
                                                                $('#charCountTitle').css('background-color', '#e53b3b9c');
                                                            }
                                                        });
                                                    </script>
                                                </div>
                                                <div class="mb-4">
                                                    <?= $form->field($model, 'seo_description')->textarea(['rows' => '4', 'class' => "form-control", 'id' => 'seo_description_id'])->label('SEO Опис' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountDescription" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="130 > 155 < 180"> 0</label>') ?>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            var textLength = $('#seo_description_id').val().length;
                                                            $('#charCountDescription').text(textLength);
                                                            if (textLength === 155) {
                                                                $('#charCountDescription').css('background-color', '#13bf3d87');
                                                            } else if (textLength >= 130 && textLength <= 154) {
                                                                $('#charCountDescription').css('background-color', '#eded248c');
                                                            } else if (textLength >= 156 && textLength <= 180) {
                                                                $('#charCountDescription').css('background-color', '#eded248c');
                                                            } else {
                                                                $('#charCountDescription').css('background-color', '#e53b3b9c');
                                                            }
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                            class="tab-pane fade"
                                            id="ru-seo-content-2"
                                            role="tabpanel"
                                            aria-labelledby="ru-seo-2">
                                        <div class="card">
                                            <?php if (isset($translateRu)): ?>
                                                <div class="card-body p-5">
                                                    <div class="mb-4">
                                                        <?= $form->field($translateRu, 'seo_title')->textInput(['maxlength' => true, 'id' => 'seo_title_ru_id', 'name' => 'BrandsTranslate[ru][seo_title]'])->label('SEO Тайтл' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountTitle_ru" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 55 < 60"> 0</label>') ?>
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                                var textLength = $('#seo_title_ru_id').val().length;
                                                                $('#charCountTitle_ru').text(textLength);
                                                                if (textLength === 55) {
                                                                    $('#charCountTitle_ru').css('background-color', '#13bf3d87');
                                                                } else if (textLength >= 50 && textLength <= 54) {
                                                                    $('#charCountTitle_ru').css('background-color', '#eded248c');
                                                                } else if (textLength >= 56 && textLength <= 60) {
                                                                    $('#charCountTitle_ru').css('background-color', '#eded248c');
                                                                } else {
                                                                    $('#charCountTitle_ru').css('background-color', '#e53b3b9c');
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="mb-4">
                                                        <?= $form->field($translateRu, 'seo_description')->textarea(['rows' => '4', 'class' => "form-control", 'id' => 'seo_description_ru_id', 'name' => 'BrandsTranslate[ru][seo_description]'])->label('SEO Опис' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountDescription_ru" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="130 > 155 < 180"> 0</label>') ?>
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                                var textLength = $('#seo_description_ru_id').val().length;
                                                                $('#charCountDescription_ru').text(textLength);
                                                                if (textLength === 155) {
                                                                    $('#charCountDescription_ru').css('background-color', '#13bf3d87');
                                                                } else if (textLength >= 130 && textLength <= 154) {
                                                                    $('#charCountDescription_ru').css('background-color', '#eded248c');
                                                                } else if (textLength >= 156 && textLength <= 180) {
                                                                    $('#charCountDescription_ru').css('background-color', '#eded248c');
                                                                } else {
                                                                    $('#charCountDescription_ru').css('background-color', '#e53b3b9c');
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= $this->render('sidebar', ['form' => $form, 'model' => $model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
