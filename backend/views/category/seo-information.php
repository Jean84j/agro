<?php

?>
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
                            <?= $form->field($model, 'pageTitle')->textInput(['maxlength' => true, 'id' => 'seo_title_id'])->label('SEO Тайтл' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountTitle" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 55 < 60"> 0</label>') ?>
                            <?= $form->field($model, 'metaDescription')->textarea(['rows' => '4', 'class' => "form-control", 'id' => 'seo_description_id'])->label('SEO Опис' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountDescription" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="130 > 155 < 180"> 0</label>') ?>
                            <?= $form->field($model, 'h1')->textInput(['maxlength' => true, 'id' => 'seo_h1'])->label('H1' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountH1" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 60 < 70"> 0</label>') ?>
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
                                <?= $form->field($translateRu, 'pageTitle')->textInput(['maxlength' => true, 'id' => 'seo_title_ru_id', 'name' => 'CategoriesTranslate[ru][pageTitle]'])->label('SEO Тайтл' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountTitle_ru" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 55 < 60"> 0</label>') ?>
                                <?= $form->field($translateRu, 'metaDescription')->textarea(['rows' => '4', 'class' => "form-control", 'id' => 'seo_description_ru_id', 'name' => 'CategoriesTranslate[ru][metaDescription]'])->label('SEO Опис' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountDescription_ru" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="130 > 155 < 180"> 0</label>') ?>
                                <?= $form->field($translateRu, 'h1')->textInput(['maxlength' => true, 'id' => 'seo_h1_ru', 'name' => 'CategoriesTranslate[ru][h1]'])->label('H1' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountH1_ru" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 60 < 70"> 0</label>') ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateCharCount(inputId, labelId, minOptimal, optimal, maxOptimal) {
            var input = document.getElementById(inputId);
            var label = document.getElementById(labelId);
            if (!input || !label) return;

            function update() {
                var length = input.value.length;
                label.textContent = length;

                let bgColor = '#e53b3b9c'; // Красный (неоптимальный)

                if (length === optimal) {
                    bgColor = '#13bf3d87'; // Зеленый (идеальный)
                } else if ((length >= minOptimal && length < optimal) || (length > optimal && length <= maxOptimal)) {
                    bgColor = '#eded248c'; // Желтый (допустимый)
                }

                label.style.backgroundColor = bgColor;
            }

            input.addEventListener('input', update);
            update(); // Первоначальный вызов для установки значения при загрузке
        }

        updateCharCount('seo_title_id', 'charCountTitle', 50, 55, 70);
        updateCharCount('seo_description_id', 'charCountDescription', 130, 155, 180);
        updateCharCount('seo_h1', 'charCountH1', 50, 60, 70);
        updateCharCount('seo_title_id_ru', 'charCountTitleRu', 50, 55, 70);
        updateCharCount('seo_description_id_ru', 'charCountDescriptionRu', 130, 155, 180);
        updateCharCount('seo_h1_ru', 'charCountH1_ru', 50, 60, 70);
    });
</script>