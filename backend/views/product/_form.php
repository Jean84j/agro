<?php

use kartik\form\ActiveForm;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\shop\Product $model */
/** @var ActiveForm $form */
/** @var backend\controllers\ProductController $dataRu */
/** @var backend\controllers\ProductController $dataEn */

$form = ActiveForm::begin([
    'id' => 'product-form', // Добавляем ID формы
    'options' => ['autocomplete' => 'off']
]);

$saveButton = Html::submitButton(
    Yii::t('app', 'Save'), [
    'class' => 'btn btn-outline-secondary',
    'id' => 'save-button',
    'disabled' => true,
]);

$params = [
    'form' => $form,
    'model' => $model,
];
if (isset($translateRu)) {
    $params['translateRu'] = $translateRu;
}
if (isset($data)) {
    $params['data'] = $data;
    $params['dataRu'] = $dataRu;
}
if (isset($variants)) {
    $params['variants'] = $variants;
}

if (isset($faq)) {
    $params['faq'] = $faq;
}

?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
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
                        <?php if (!$model->isNewRecord): ?>
                            <?= Html::a(Yii::t('app', 'List'), Url::to(['index']), ['class' => 'btn btn-outline-info me-3']) ?>
                            <?= Html::a(Yii::t('app', 'Create more'), Url::to(['create']), ['class' => 'btn btn-outline-success me-3']) ?>
                        <?php endif; ?>
                        <?= $saveButton ?>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout"
                 data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
                <div class="sa-entity-layout__body">
                    <div class="sa-entity-layout__main">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                        class="nav-link active"
                                        id="description-tab-1"
                                        data-bs-toggle="tab"
                                        data-bs-target="#description-tab-content-1"
                                        type="button"
                                        role="tab"
                                        aria-controls="description-tab-content-1"
                                        aria-selected="true"
                                >
                                    <span class="text-center-info">
                                        <i class="fas fa-info-circle color-info"></i>
                                        <span>Основна інформація</span>
                                    </span>
                                    <span class="nav-link-sa-indicator"></span>
                                </button>
                            </li>
                            <?php if (!$model->isNewRecord): ?>
                                <li class="nav-item" role="presentation">
                                    <button
                                            class="nav-link"
                                            id="seo-tab-1"
                                            data-bs-toggle="tab"
                                            data-bs-target="#seo-tab-content-1"
                                            type="button"
                                            role="tab"
                                            aria-controls="seo-tab-content-1"
                                            aria-selected="true"
                                    >
                                    <span class="text-center-info">
                                        <i class="fas fa-search-dollar color-info"></i>
                                        <span>Просунення в пошуку</span>
                                    </span>
                                        <span class="nav-link-sa-indicator"></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                            class="nav-link"
                                            id="properties-tab-1"
                                            data-bs-toggle="tab"
                                            data-bs-target="#properties-tab-content-1"
                                            type="button"
                                            role="tab"
                                            aria-controls="properties-tab-content-1"
                                            aria-selected="true"
                                    >
                                    <span class="text-center-info">
                                        <i class="fas fa-list color-info"></i>
                                        <span>Характеристики</span>
                                    </span>
                                        <span class="nav-link-sa-indicator"></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                            class="nav-link"
                                            id="keyword-tab-1"
                                            data-bs-toggle="tab"
                                            data-bs-target="#keyword-tab-content-1"
                                            type="button"
                                            role="tab"
                                            aria-controls="keyword-tab-content-1"
                                            aria-selected="true"
                                    >
                                    <span class="text-center-info">
                                        <i class="fas fa-key color-info"></i>
                                        <span>Ключові слова</span>
                                    </span>
                                        <span class="nav-link-sa-indicator"></span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                            class="nav-link"
                                            id="faq-tab-1"
                                            data-bs-toggle="tab"
                                            data-bs-target="#faq-tab-content-1"
                                            type="button"
                                            role="tab"
                                            aria-controls="faq-tab-content-1"
                                            aria-selected="true"
                                    >
                                    <span class="text-center-info">
                                        <i class="far fa-question-circle color-info"></i>
                                        <span>Запитання</span>
                                    </span>
                                        <span class="nav-link-sa-indicator"></span>
                                    </button>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <div class="tab-content mt-4">
                            <div
                                    class="tab-pane fade show active"
                                    id="description-tab-content-1"
                                    role="tabpanel"
                                    aria-labelledby="description-tab-1"
                            >
                                <?php echo $this->render('basic-information', $params); ?>
                            </div>
                            <div
                                    class="tab-pane fade"
                                    id="seo-tab-content-1"
                                    role="tabpanel"
                                    aria-labelledby="seo-tab-1"
                            >
                                <?php echo $this->render('seo-information', $params); ?>
                            </div>
                            <div
                                    class="tab-pane fade"
                                    id="properties-tab-content-1"
                                    role="tabpanel"
                                    aria-labelledby="properties-tab-1"
                            >
                                <?php echo $this->render('properties-information', $params); ?>
                            </div>
                            <div
                                    class="tab-pane fade"
                                    id="keyword-tab-content-1"
                                    role="tabpanel"
                                    aria-labelledby="keyword-tab-1"
                            >
                                <?php echo $this->render('keywords', $params); ?>
                            </div>
                            <div
                                    class="tab-pane fade"
                                    id="faq-tab-content-1"
                                    role="tabpanel"
                                    aria-labelledby="faq-tab-1"
                            >
                                <?php echo $this->render('faq', $params); ?>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->render('sidebar', $params); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<style>
    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 35px;
        user-select: none;
        -webkit-user-select: none;
        /* width: max-content; */
    }

    .color-info {
        color: #ef0f0f6b;
        font-size: 25px;
    }

    .text-center-info {
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let form = document.getElementById("product-form");
        let saveButton = document.getElementById("save-button");

        function activateButton() {
            saveButton.classList.remove("btn-outline-secondary");
            saveButton.classList.add("btn-primary");
            saveButton.removeAttribute("disabled");
        }

        form.addEventListener("input", activateButton);

        $('#product-form').on('select2:select select2:unselect', '.sa-select2', activateButton);
    });
</script>




