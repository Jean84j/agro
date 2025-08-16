<?php


?>
<div class="card mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart">
                                        <h2 class="mb-0 fs-exact-18">
                                            <?= Yii::t('app', 'Seo') ?> UK
                                        </h2>
                                    </span>
        </div>
        <div class="row g-4 card card-body">
            <?= $form->field($model, 'seo_title')->textInput([
                'maxlength' => true,
                'id' => 'seo_title_id',
            ])->label('SEO Тайтл' . ' ' . '->' . ' ' . '<label 
class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" 
style="background: #63bdf57d" 
id="charCountTitle" 
data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 55 < 70"> 0</label>') ?>

            <?= $form->field($model, 'seo_description')->textarea([
                'rows' => '4',
                'class' => "form-control",
                'id' => 'seo_description_id',
            ])->label('SEO Опис' . ' ' . '->' . ' ' . '<label 
class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" 
style="background: #63bdf57d" 
id="charCountDescription" 
data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="130 > 155 < 180"> 0</label>') ?>



            <?= $form->field($model, 'h1')->textInput([
                'maxlength' => true,
                'id' => 'h1_id',
            ])->label('H1' . ' ' . '->' . ' ' . '<label 
class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" 
style="background: #63bdf57d" 
id="charCountH1" 
data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 60 < 70"> 0</label>') ?>



        </div>
    </div>
</div>
<?php if (isset($translateRu)): ?>
    <div class="card mt-5">
        <div class="card-body p-5">
            <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart">
                                        <h2 class="mb-0 fs-exact-18">
                                            <?= Yii::t('app', 'Seo') ?> RU
                                        </h2>
                                    </span>
            </div>
            <div class="row g-4 card card-body">
                <?= $form->field($translateRu, 'seo_title')->textInput([
                    'maxlength' => true,
                    'id' => 'seo_title_id_ru',
                    'name' => 'ProductsTranslate[ru][seo_title]',
                ])->label('SEO Тайтл' . ' ' . '->' . ' ' . '<label 
class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" 
style="background: #63bdf57d" 
id="charCountTitleRu" 
data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 55 < 70"> 0</label>') ?>

                <?= $form->field($translateRu, 'seo_description')->textarea([
                    'rows' => '4',
                    'class' => "form-control",
                    'id' => 'seo_description_id_ru',
                    'name' => 'ProductsTranslate[ru][seo_description]',
                ])->label('SEO Опис' . ' ' . '->' . ' ' . '<label 
class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" 
style="background: #63bdf57d" 
id="charCountDescriptionRu" 
data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="130 > 155 < 180"> 0</label>') ?>



                <?= $form->field($translateRu, 'h1')->textInput([
                    'maxlength' => true,
                    'id' => 'h1_id_ru',
                    'name' => 'ProductsTranslate[ru][h1]',
                ])->label('H1' . ' ' . '->' . ' ' . '<label 
class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart" 
style="background: #63bdf57d" 
id="charCountH1Ru" 
data-bs-toggle="tooltip"
                               data-bs-placement="right"
                               title="50 > 60 < 70"> 0</label>') ?>



            </div>
        </div>
    </div>
<?php endif; ?>
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
        updateCharCount('h1_id', 'charCountH1', 50, 60, 70);
        updateCharCount('seo_title_id_ru', 'charCountTitleRu', 50, 55, 70);
        updateCharCount('seo_description_id_ru', 'charCountDescriptionRu', 130, 155, 180);
        updateCharCount('h1_id_ru', 'charCountH1Ru', 50, 60, 70);
    });
</script>
