<?php


?>
<div class="card mt-5">
    <div class="card-header">
        <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                                                class="mb-0 fs-exact-18"><?= Yii::t('app', 'Keywords') ?></h2></span>

        </div>
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link active"
                        id="uk-keywords-2"
                        data-bs-toggle="tab"
                        data-bs-target="#uk-keywords-content-2"
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
                            id="ru-keywords-2"
                            data-bs-toggle="tab"
                            data-bs-target="#ru-keywords-content-2"
                            type="button"
                            role="tab"
                            aria-controls="ru-keywords-content-2"
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
                    id="uk-keywords-content-2"
                    role="tabpanel"
                    aria-labelledby="uk-keywords-2">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                                                class="mb-0 fs-exact-18"><?= Yii::t('app', 'Keywords') ?> UK</h2></span>
                        </div>
                        <div class="row g-4">
                            <?= $form->field($model, 'keywords')->textInput([
                                'maxlength' => true,
                            ])->label('Keywords') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div
                    class="tab-pane fade"
                    id="ru-keywords-content-2"
                    role="tabpanel"
                    aria-labelledby="ru-keywords-2">
                <div class="card">
                    <?php if (isset($translateRu)): ?>
                        <div class="card-body p-5">
                            <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                                                class="mb-0 fs-exact-18"><?= Yii::t('app', 'Keywords') ?> RU</h2></span>
                            </div>
                            <div class="row g-4">
                                <?= $form->field($translateRu, 'keywords')->textInput([
                                    'maxlength' => true,
                                    'name' => 'CategoriesTranslate[ru][keywords]',
                                ])->label('Keywords') ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

