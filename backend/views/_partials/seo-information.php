<?php

$seoRules = Yii::$app->params['seoRules'];

?>
<div class="card">
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
                        <div class="card card-body mb-4">
                            <?= $form->field($model, $seoTitle)->textInput([
                                'maxlength' => true,
                                'id' => 'seo_title'
                            ])->label('SEO Тайтл') ?><?= charProgress('seo_title', $seoRules['seo_title']) ?>
                        </div>
                        <div class="card card-body mb-4">
                            <?= $form->field($model, $seoDescription)->textarea([
                                'rows' => 4,
                                'id' => 'seo_description'
                            ])->label('SEO Опис') ?><?= charProgress('seo_description', $seoRules['seo_description']) ?>
                        </div>
                        <div class="card card-body mb-4">
                            <?= $form->field($model, $seoH1)->textInput([
                                'maxlength' => true,
                                'id' => 'seo_h1'
                            ])->label('H1') ?><?= charProgress('seo_h1', $seoRules['seo_h1']) ?>
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
                    <!-- RU TAB -->
                    <?php if (isset($translateRu)): ?>
                        <div class="tab-pane fade" id="ru-seo-content-2" role="tabpanel" aria-labelledby="ru-seo-2">
                            <div class="card card-body mb-4">
                                <?= $form->field($translateRu, $seoTitleRu)->textInput([
                                    'maxlength' => true,
                                    'id' => 'seo_title_ru',
                                    'name' => "Translate[ru][{$seoTitleRu}]"
                                ])->label('SEO Тайтл') ?><?= charProgress('seo_title_ru', $seoRules['seo_title']) ?>
                            </div>
                            <div class="card card-body mb-4">
                                <?= $form->field($translateRu, $seoDescriptionRu)->textarea([
                                    'rows' => 4,
                                    'id' => 'seo_description_ru',
                                    'name' => "Translate[ru][{$seoDescriptionRu}]"
                                ])->label('SEO Опис') ?><?= charProgress('seo_description_ru', $seoRules['seo_description']) ?>
                            </div>
                            <div class="card card-body mb-4">
                                <?= $form->field($translateRu, $seoH1Ru)->textInput([
                                    'maxlength' => true,
                                    'id' => 'seo_h1_ru',
                                    'name' => "Translate[ru][{$seoH1Ru}]"
                                ])->label('H1') ?><?= charProgress('seo_h1_ru', $seoRules['seo_h1']) ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
function charProgress($id, $rules)
{
    $min = $rules['min'];
    $optimal = $rules['optimal'];
    $max = $rules['max'];

    return "
        <div class='char-counter mt-2'
             data-id='{$id}'
             data-min='{$min}'
             data-optimal='{$optimal}'
             data-max='{$max}'>
            <div class='d-flex justify-content-between'>
                <small>Рекомендовано: {$min}-{$max} символов (идеал ~{$optimal})</small>
                <small id='{$id}_count'>0</small>
            </div>
            <div class='progress' style='height: 6px;'>
                <div id='{$id}_bar' 
                     class='progress-bar bg-danger' 
                     role='progressbar' 
                     style='width: 0%; transition: width 0.3s ease, background-color 0.3s ease'>
                </div>
            </div>
        </div>
    ";
}

?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.char-counter').forEach(wrapper => {
            const id = wrapper.dataset.id;
            const minOptimal = parseInt(wrapper.dataset.min);
            const optimal = parseInt(wrapper.dataset.optimal);
            const maxOptimal = parseInt(wrapper.dataset.max);

            const input = document.getElementById(id);
            const counter = document.getElementById(id + '_count');
            const bar = document.getElementById(id + '_bar');
            if (!input || !counter || !bar) return;

            const update = () => {
                const length = input.value.length;
                counter.textContent = length;

                let percent = Math.min((length / maxOptimal) * 100, 100);
                bar.style.width = percent + "%";

                if (length >= minOptimal && length <= maxOptimal) {
                    if (length === optimal) {
                        bar.className = "progress-bar bg-success"; // идеально
                    } else {
                        bar.className = "progress-bar bg-warning"; // нормально
                    }
                } else {
                    bar.className = "progress-bar bg-danger"; // плохо
                }
            };

            input.addEventListener('input', update);
            update();
        });
    });
</script>
