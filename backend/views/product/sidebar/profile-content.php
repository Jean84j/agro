<?php

use common\models\shop\Grup;
use common\models\shop\Label;
use backend\models\ProductsBackend;
use common\models\shop\Tag;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-3">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                        class="mb-0 fs-exact-18"><?= Yii::t('app', 'Variants') ?></h2></span>
            <a href="#" data-bs-toggle="modal"
               data-bs-target="#addVariantModal">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
    <div class="mt-n5">
        <div class="sa-divider"></div>

        <div class="table-responsive">
            <table class="sa-table">
                <thead>
                <tr>
                    <th class="min-w-5x">Назва</th>
                    <th class="w-min">Значення</th>
                    <th class="w-min"></th>
                </tr>
                </thead>
                <?= $this->render('modal-add-variant', ['model' => $model]) ?>
                <tbody id="variant-table">
                <?php if (!empty($variants)) : ?>
                    <?php $productId = $model->id;
                    $i = 0; ?>
                    <?php foreach ($variants as $variant) : ?>
                        <tr>
                            <td>
                                <input type="text" name="variant[<?= $variant['id'] ?>]"
                                       class="form-control form-control-sm"
                                       value="<?= $variant['name'] ?>" readonly/>
                            </td>
                            <td>
                                <input type="text" name="volume[<?= $variant['id'] ?>]"
                                       class="form-control form-control-sm wx-4x"
                                       value="<?= $variant['volume'] ?>" readonly/>
                            </td>
                            <td>
                                <a href="#"
                                   id="<?= $variant['id'] ?>"
                                   data-productId="<?= $productId ?>"
                                   data-variantId="<?= $variant['product_variant_id'] ?>"

                                   class="text-danger del-variant"
                                   onclick="return confirm('Вы уверены, что хотите удалить этот товар из заказа?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                         height="12" viewBox="0 0 12 12" fill="currentColor">
                                        <path d="M10.8,10.8L10.8,10.8c-0.4,0.4-1,0.4-1.4,0L6,7.4l-3.4,3.4c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L4.6,6L1.2,2.6 c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L6,4.6l3.4-3.4c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L7.4,6l3.4,3.4 C11.2,9.8,11.2,10.4,10.8,10.8z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <?php $i++; endforeach; ?>
                <?php endif; ?>
                </tbody>

            </table>
        </div>

        <div class="sa-divider"></div>
    </div>
</div>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                        class="mb-0 fs-exact-18"><?= Yii::t('app', 'Tag') ?></h2></span>
        </div>
        <div class="card card-body">
            <?php
            $data = ArrayHelper::map(Tag::find()->orderBy('id')->asArray()->all(), 'id', 'name');
            echo $form->field($model, 'tags')->widget(Select2::class, [
                'data' => $data,
                'theme' => Select2::THEME_DEFAULT,
                'maintainOrder' => true,
                'pluginLoading' => false,
                'toggleAllSettings' => [
                    'selectLabel' => '<i class="fas fa-check-circle"></i> Выбрать все',
                    'unselectLabel' => '<i class="fas fa-times-circle"></i> Удалить все',
                    'selectOptions' => ['class' => 'text-success'],
                    'unselectOptions' => ['class' => 'text-danger'],
                ],
                'options' => [
                    'placeholder' => 'Виберіть тег ...',
                    'class' => 'sa-select2 form-select',
                    // 'data-tags'=>'true',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'closeOnSelect' => false,
                    'tags' => true,
                    'tokenSeparators' => [', ', ' '],
                    'maximumInputLength' => 10,
                    'width' => '273px',
                ],
            ])->label(false);
            ?>
        </div>
    </div>
</div>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                        class="mb-0 fs-exact-18"><?= Yii::t('app', 'Group') ?></h2></span>
        </div>
        <div class="card card-body">
            <?php
            $data = ArrayHelper::map(Grup::find()->orderBy('id')->asArray()->all(), 'id', 'name');
            echo $form->field($model, 'grups')->widget(Select2::class, [
                'data' => $data,
                'theme' => Select2::THEME_DEFAULT,
                'maintainOrder' => true,
                'pluginLoading' => false,
                'toggleAllSettings' => [
                    'selectLabel' => '<i class="fas fa-check-circle"></i> Выбрать все',
                    'unselectLabel' => '<i class="fas fa-times-circle"></i> Удалить все',
                    'selectOptions' => ['class' => 'text-success'],
                    'unselectOptions' => ['class' => 'text-danger'],
                ],
                'options' => [
                    'placeholder' => 'Виберіть групу ...',
                    'class' => 'sa-select2 form-select',
                    // 'data-tags'=>'true',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'closeOnSelect' => false,
                    'grups' => true,
                    'tokenSeparators' => [', ', ' '],
                    'maximumInputLength' => 10,
                    'width' => '273px',
                ],
            ])->label(false);
            ?>
        </div>
    </div>
</div>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                        class="mb-0 fs-exact-18"><?= Yii::t('app', 'Label') ?></h2></span>
        </div>
        <div class="card card-body ">
            <?php
            $data = ArrayHelper::map(Label::find()
                ->orderBy('name')->asArray()->all(), 'id', 'name');
            echo $form->field($model, 'label_id')->widget(Select2::class, [
                'data' => $data,
                'theme' => Select2::THEME_DEFAULT,
                'pluginLoading' => false,
                'options' => [
                    'placeholder' => 'Виберіть мітку ...',
                    'class' => 'sa-select2 form-select',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '273px',
                ],
            ])->label(false); ?>
        </div>
    </div>
</div>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                        class="mb-0 fs-exact-18"><?= Yii::t('app', 'Analog') ?></h2></span>
        </div>
        <div class="card card-body ">
            <?php
            $data = ArrayHelper::map(ProductsBackend::find()->orderBy('id')->asArray()->all(), 'id', 'name');
            echo $form->field($model, 'analogs')->widget(Select2::class, [
                'data' => $data,
                'theme' => Select2::THEME_DEFAULT,
                'maintainOrder' => true,
                'pluginLoading' => false,
                'toggleAllSettings' => [
                    'selectLabel' => '<i class="fas fa-check-circle"></i> Выбрать все',
                    'unselectLabel' => '<i class="fas fa-times-circle"></i> Удалить все',
                    'selectOptions' => ['class' => 'text-success'],
                    'unselectOptions' => ['class' => 'text-danger'],
                ],
                'options' => [
                    'placeholder' => 'Виберіть аналог ...',
                    'class' => 'sa-select2 form-select',
                    // 'data-tags'=>'true',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'closeOnSelect' => false,
                    'tags' => true,
                    'tokenSeparators' => [', ', ' '],
                    'maximumInputLength' => 10,
                    'width' => '273px',
                ],
            ])->label(false);
            ?>
        </div>
    </div>
</div>
