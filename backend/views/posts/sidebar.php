<?php

use backend\models\ProductsBackend;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\Posts $model */
/** @var yii\widgets\ActiveForm $form */

?>
<div class="sa-entity-layout__sidebar">
    <div class="card w-100">
        <div class="card-body p-5">
            <?= $this->render('/_partials/card-name-label', ['cardName' => 'Product post']); ?>
            <div class="mb-4">
                <?php
                $data = ArrayHelper::map(ProductsBackend::find()->orderBy('id')->asArray()->all(), 'id', 'name');
                echo $form->field($model, 'products')->widget(Select2::class, [
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
                        'placeholder' => 'Виберіть продукт ...',
                        'class' => 'sa-select2 form-select',
                        // 'data-tags'=>'true',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'closeOnSelect' => false,
                        'tags' => true,
                        'tokenSeparators' => [', ', ' '],
                        'maximumInputLength' => 10,
                        'width' => '100%',
                    ],
                ])->label(false);
                ?>
            </div>
        </div>
    </div>
    <?= $this->render('/_partials/image-upload', $commonParams) ?>
</div>