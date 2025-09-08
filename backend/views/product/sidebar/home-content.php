<?php

use common\models\shop\Brand;
use common\models\shop\Category;
use common\models\shop\Status;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

?>
<div class="card w-100">
    <div class="card-body p-5">
        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Category') ?></h2></span>
        </div>
        <div class="card card-body">
            <?php
            Pjax::begin(['id' => "category"]);
            $data = ArrayHelper::map(Category::find()
                ->where(['visibility' => true])
                ->orderBy('name')
                ->asArray()
                ->all(), 'id', 'name');
            echo $form->field($model, 'category_id')->widget(Select2::class, [
                'data' => $data,
                'theme' => Select2::THEME_DEFAULT,
                'maintainOrder' => true,
                'pluginLoading' => false,
                'options' => [
                    'placeholder' => 'Виберіть категорію ...',
                    'class' => 'sa-select2 form-select',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '273px',
                ],
            ])->label(false);
            Pjax::end();
            ?>
        </div>
    </div>
</div>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Status') ?></h2></span>
        </div>
        <div class="card card-body mb-4">
            <?= $form->field($model, 'status_id')
                ->radioList(
                    ArrayHelper::map(Status::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            $return = '<label class="form-check">';
                            $return .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>';
                            $return .= ucwords($label);
                            $return .= '</label>';
                            return $return;
                        },

                    ],
                )->label(false); ?>
        </div>
    </div>
</div>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Package') ?></h2></span>
        </div>
        <div class="card card-body mb-4">
            <?= $form->field($model, 'package')
                ->radioList(
                    [
                        'BIG' => 'Фермер',
                        'SMALL' => 'Дачник',
                    ],
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            $return = '<label class="form-check">';
                            $return .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>';
                            $return .= ucwords($label);
                            $return .= '</label>';
                            return $return;
                        },

                    ],
                )->label(false); ?>
        </div>
    </div>
</div>
<div class="card w-100 mt-5">
    <div class="card-body">
        <div>
                        <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                                    class="mb-0 fs-exact-18"><?= Yii::t('app', 'Prices') ?></h2></span>
        </div>
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="price-tab-2" data-bs-toggle="tab"
                            data-bs-target="#price-tab-content-2" type="button" role="tab"
                            aria-controls="price-tab-content-2" aria-selected="true">
                        Ціна<span class="nav-link-sa-indicator"></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="currency-tab-2" data-bs-toggle="tab"
                            data-bs-target="#currency-tab-content-2" type="button" role="tab"
                            aria-controls="currency-tab-content-2" aria-selected="true">
                        Валюта<span class="nav-link-sa-indicator"></span>
                    </button>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="price-tab-content-2" role="tabpanel"
                 aria-labelledby="price-tab-2">
                <div class="card card-body mt-4">
                    <div>
                        <?= $form->field($model, 'price')->textInput([
                            'class' => "form-control"
                        ]) ?>
                    </div>
                    <div>
                        <?= $form->field($model, 'old_price')->textInput([
                            'class' => "form-control"
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="currency-tab-content-2" role="tabpanel" aria-labelledby="currency-tab-2">
                <div class="card card-body mt-4">
                    <?= $form->field($model, 'currency')
                        ->radioList(
                            [
                                'UAH' => 'Гривня',
                                'USD' => 'Долар',
                            ],
                            [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $return = '<label class="form-check">';
                                    $return .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>';
                                    $return .= ucwords($label);
                                    $return .= '</label>';
                                    return $return;
                                },

                            ],
                        )->label(false); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Brand') ?></h2></span>
        </div>
        <div class="card card-body ">
            <?php
            $data = ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
            echo $form->field($model, 'brand_id')->widget(Select2::class, [
                'data' => $data,
                'theme' => Select2::THEME_DEFAULT,
                'pluginLoading' => false,
                'options' => [
                    'placeholder' => 'Виберіть Бренд ...',
                    'class' => 'sa-select2 form-select',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '273px',
                ],
            ])->label(false);
            ?>
        </div>
    </div>
</div>