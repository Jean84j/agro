<?php

use kartik\form\ActiveForm;
use yii\bootstrap5\Breadcrumbs;
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

    'seoTitle' => 'seo_title',
    'seoDescription' => 'seo_description',
    'seoH1' => 'h1',
    'seoTitleRu' => 'seo_title',
    'seoDescriptionRu' => 'seo_description',
    'seoH1Ru' => 'h1',
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

if (isset($words)) {
    $params['words'] = $words;
}

$tabs = $model->getTabs();
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
            <div class="pt-3">
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
                        <?= $this->render('/_partials/tabs', ['tabs' => $tabs, 'params' => $params]); ?>
                    </div>
                    <?php echo $this->render('/product/sidebar/sidebar', $params); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
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



