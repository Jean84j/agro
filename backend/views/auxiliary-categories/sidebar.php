<?php

use common\models\shop\Category;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>
<div class="sa-entity-layout__sidebar">
    <div class="card w-100">
        <div class="card-body p-5">
            <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2 class="mb-0 fs-exact-18"><?= Yii::t('app', 'visibility') ?></h2></span>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'visibility')
                    ->radioList(
                        [
                            1 => Yii::t('app', 'Published'),
                            0 => Yii::t('app', 'Hidden'),
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
        <div class="card-body p-5">
            <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2 class="mb-0 fs-exact-18"><?= Yii::t('app', 'Parent category') ?></h2></span>
            </div>
            <?php
            $data = ArrayHelper::map(Category::find()
                ->where('parentId IS NOT NULL')->orderBy('id')
                ->asArray()->all(), 'id', 'name');
            echo $form->field($model, 'parentId')->widget(Select2::class, [
                'data' => $data,
                'theme' => Select2::THEME_DEFAULT,
                'maintainOrder' => true,
                'pluginLoading' => false,
                'options' => [
                    'placeholder' => Yii::t('app', 'Select category...'),
                    'class' => 'sa-select2 form-select',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '272px',
                ],
            ])->label(false);
            ?>
            <!--                                <div class="form-text">--><?php //= Yii::t('app', 'Select a category that will be the parent of the current one.') ?><!--</div>-->
        </div>
    </div>

    <?= $this->render('/_partials/image-upload', $params) ?>

</div>
