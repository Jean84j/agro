<?php

?>
<div class="card mt-5">
    <div class="card-header">
        <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Search engine optimization ') ?>Шаблон</h2></span>
        </div>
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="uk-product-seo-layout-2"
                    data-bs-toggle="tab"
                    data-bs-target="#uk-product-seo-layout-content-2"
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
                        id="ru-product-seo-layout-2"
                        data-bs-toggle="tab"
                        data-bs-target="#ru-product-seo-layout-content-2"
                        type="button"
                        role="tab"
                        aria-controls="ru-product-seo-layout-content-2"
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
                id="uk-product-seo-layout-content-2"
                role="tabpanel"
                aria-labelledby="uk-product-seo-layout-2">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <?= $form->field($model, 'product_title')->textInput(['maxlength' => true, 'id' => 'product_seo_layout_title_id'])->label('product-seo-layout Тайтл' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountTitle" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 55 < 60"> 0</label>') ?>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var textLength = $('#product_seo_layout_title_id').val().length;
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
                            <?= $form->field($model, 'product_description')->textarea(['rows' => '4', 'class' => "form-control", 'id' => 'product_seo_layout_description_id'])->label('product-seo-layout Опис' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountDescription" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="130 > 155 < 180"> 0</label>') ?>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var textLength = $('#product_seo_layout_description_id').val().length;
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
                id="ru-product-seo-layout-content-2"
                role="tabpanel"
                aria-labelledby="ru-product-seo-layout-2">
                <div class="card">
                    <?php if (isset($translateRu)): ?>
                        <div class="card-body p-5">
                            <div class="mb-4">
                                <?= $form->field($translateRu, 'product_title')->textInput(['maxlength' => true, 'id' => 'product_seo_layout_title_ru_id', 'name' => 'CategoriesTranslate[ru][product_title]'])->label('product-seo-layout Тайтл' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountTitle_ru" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 55 < 60"> 0</label>') ?>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        var textLength = $('#product_seo_layout_title_ru_id').val().length;
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
                                <?= $form->field($translateRu, 'product_description')->textarea(['rows' => '4', 'class' => "form-control", 'id' => 'product_seo_layout_description_ru_id', 'name' => 'CategoriesTranslate[ru][product_description]'])->label('product-seo-layout Опис' . ' ' . '->' . ' ' . '<label class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" style="background: #63bdf57d" id="charCountDescription_ru" data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="130 > 155 < 180"> 0</label>') ?>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        var textLength = $('#product_seo_layout_description_ru_id').val().length;
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
