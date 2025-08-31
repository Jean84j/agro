<?php

?>
<div class="card mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
            <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart">
                <h2 class="mb-0 fs-exact-18">
                    <?= Yii::t('app', 'Search engine optimization') ?>
                </h2>
            </span>
        </div>
        <div class="card">
            <div class="card-header card-background_color">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active"
                                id="uk-seo-2"
                                data-bs-toggle="tab"
                                data-bs-target="#uk-seo-content-2"
                                type="button"
                                role="tab"
                                aria-controls="uk-tab-content-2"
                                aria-selected="true">
                            UK<span class="nav-link-sa-indicator"></span>
                        </button>
                    </li>
                    <?php if (isset($translateRu)): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link"
                                    id="ru-seo-2"
                                    data-bs-toggle="tab"
                                    data-bs-target="#ru-seo-content-2"
                                    type="button"
                                    role="tab"
                                    aria-controls="ru-seo-content-2"
                                    aria-selected="false">
                                RU<span class="nav-link-sa-indicator"></span>
                            </button>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="card-body card-background_color">
                <div class="tab-content">
                    <!-- UK TAB -->
                    <div class="tab-pane fade show active" id="uk-seo-content-2" role="tabpanel"
                         aria-labelledby="uk-seo-2">
                        <div class="card-body p-5">
                            <div class="card card-body mb-5">
                                <?= $form->field($model, $seoTitle)->textInput([
                                    'maxlength' => true,
                                    'id' => 'seo_title'
                                ])->label('SEO Тайтл → ' . badgeLabel('charCountTitle', '50 > 55 < 60')) ?>
                            </div>
                            <div class="card card-body mb-5">
                                <?= $form->field($model, $seoDescription)->textarea([
                                    'rows' => 4,
                                    'id' => 'seo_description'
                                ])->label('SEO Опис → ' . badgeLabel('charCountDescription', '130 > 155 < 180')) ?>
                            </div>
                            <div class="card card-body mb-5">
                                <?= $form->field($model, $seoH1)->textInput([
                                    'maxlength' => true,
                                    'id' => 'seo_h1'
                                ])->label('H1 → ' . badgeLabel('charCountH1', '50 > 60 < 70')) ?>
                            </div>
                            <div class="card card-body">
                                <?= $form->field($model, 'keywords')->textarea([
                                    'maxlength' => true,
                                    'rows' => '4',
                                    'class' => "form-control",
                                    'id' => 'keywords',
                                ])->label('Keywords') ?>
                            </div>
                        </div>
                    </div>
                    <!-- RU TAB -->
                    <?php if (isset($translateRu)): ?>
                        <div class="tab-pane fade" id="ru-seo-content-2" role="tabpanel" aria-labelledby="ru-seo-2">
                            <div class="card-body p-5">
                                <div class="card card-body mb-5">
                                    <?= $form->field($translateRu, $seoTitleRu)->textInput([
                                        'maxlength' => true,
                                        'id' => 'seo_title_ru',
                                        'name' => "Translate[ru][{$seoTitleRu}]"
                                    ])->label('SEO Тайтл → ' . badgeLabel('charCountTitle_ru', '50 > 55 < 60')) ?>
                                </div>
                                <div class="card card-body mb-5">
                                    <?= $form->field($translateRu, $seoDescriptionRu)->textarea([
                                        'rows' => 4,
                                        'id' => 'seo_description_ru',
                                        'name' => "Translate[ru][{$seoDescriptionRu}]"
                                    ])->label('SEO Опис → ' . badgeLabel('charCountDescription_ru', '130 > 155 < 180')) ?>
                                </div>
                                <div class="card card-body mb-5">
                                    <?= $form->field($translateRu, $seoH1Ru)->textInput([
                                        'maxlength' => true,
                                        'id' => 'seo_h1_ru',
                                        'name' => "Translate[ru][{$seoH1Ru}]"
                                    ])->label('H1 → ' . badgeLabel('charCountH1_ru', '50 > 60 < 70')) ?>
                                </div>
                                <div class="card card-body">
                                    <?= $form->field($translateRu, 'keywords')->textarea([
                                        'maxlength' => true,
                                        'rows' => '4',
                                        'class' => "form-control",
                                        'id' => 'keywords_ru',
                                        'name' => 'Translate[ru][keywords]',
                                    ])->label('Keywords') ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// Вспомогательная функция для бейджа
function badgeLabel($id, $title)
{
    return "<span 
                class='sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart'
                style='background: #63bdf57d'
                id='{$id}'
                data-bs-toggle='tooltip'
                data-bs-placement='right'
                title='{$title}'>0</span>";
}
?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        function updateCharCount(inputId, labelId, minOptimal, optimal, maxOptimal) {
            const input = document.getElementById(inputId);
            const label = document.getElementById(labelId);
            if (!input || !label) return;

            const update = () => {
                const length = input.value.length;
                label.textContent = length;

                let bgColor = '#e53b3b9c'; // Красный (плохо)

                if (length === optimal) {
                    bgColor = '#13bf3d87'; // Зеленый (идеально)
                } else if (
                    (length >= minOptimal && length < optimal) ||
                    (length > optimal && length <= maxOptimal)
                ) {
                    bgColor = '#eded248c'; // Желтый (норм)
                }

                label.style.backgroundColor = bgColor;
            };

            input.addEventListener('input', update);
            update();
        }

        // UK
        updateCharCount('seo_title', 'charCountTitle', 50, 55, 70);
        updateCharCount('seo_description', 'charCountDescription', 130, 155, 180);
        updateCharCount('seo_h1', 'charCountH1', 50, 60, 70);

        // RU
        updateCharCount('seo_title_ru', 'charCountTitle_ru', 50, 55, 70);
        updateCharCount('seo_description_ru', 'charCountDescription_ru', 130, 155, 180);
        updateCharCount('seo_h1_ru', 'charCountH1_ru', 50, 60, 70);
    });
</script>
