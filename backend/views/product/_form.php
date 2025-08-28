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
                            <?php foreach ($tabs as $tab): ?>
                                <li class="nav-item" role="presentation">
                                    <button
                                            class="nav-link <?= !empty($tab['active']) ? 'active' : '' ?>"
                                            id="<?= $tab['id'] ?>-tab-1"
                                            data-bs-toggle="tab"
                                            data-bs-target="#<?= $tab['id'] ?>-tab-content-1"
                                            type="button"
                                            role="tab"
                                            aria-controls="<?= $tab['id'] ?>-tab-content-1"
                                            aria-selected="<?= !empty($tab['active']) ? 'true' : 'false' ?>"
                                    >
                                            <span class="text-center-info">
                                                <i class="<?= $tab['icon'] ?> color-info"></i>
                                                <span><?= $tab['label'] ?></span>
                                            </span>
                                        <span class="nav-link-sa-indicator"></span>
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="tab-content mt-4">
                            <?php foreach ($tabs as $tab): ?>
                                <div
                                        class="tab-pane fade <?= !empty($tab['active']) ? 'show active' : '' ?>"
                                        id="<?= $tab['id'] ?>-tab-content-1"
                                        role="tabpanel"
                                        aria-labelledby="<?= $tab['id'] ?>-tab-1"
                                >
                                    <?= $this->render($tab['view'], $params) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php echo $this->render('sidebar/sidebar', $params); ?>
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

    .highlight {
        background-color: rgba(255, 255, 0, 0.68);
        font-weight: bold;
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

<script>
    const words = <?= json_encode($words ?? [], JSON_UNESCAPED_UNICODE) ?>;

    function highlightWords(selector, words) {
        const element = document.querySelector(selector);
        if (!element) return;

        let html = element.innerHTML;

        words.forEach(item => {
            [item.uk_word, item.ru_word].forEach(word => {
                if (!word) return;
                const regex = new RegExp(`(${word})`, "gi");
                html = html.replace(regex, '<span class="highlight">$1</span>');
            });
        });

        element.innerHTML = html;
    }
    // Запускаем подсветку
    document.addEventListener("DOMContentLoaded", function() {
        highlightWords("#doc-short_description", words);
        highlightWords("#doc-description", words);
        highlightWords("#doc-footer_description", words);
        highlightWords("#ru-short_description", words);
        highlightWords("#ru-description", words);
        highlightWords("#ru-footer_description", words);
    });
</script>



