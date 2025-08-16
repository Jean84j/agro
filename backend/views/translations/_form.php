<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Translations $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(); ?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container container--max--xl">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-auto d-flex">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout"
                 data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
                <div class="sa-entity-layout__body">
                    <div class="sa-entity-layout__main">
                        <div class="card">
                            <div class="card-body p-5">
                                <div class="mb-5"><h2
                                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Basic information') ?></h2>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-4">
                                        <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-4 mb-4">
                                        <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-4 mb-4">
                                        <?= $form->field($model, 'translation')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-4 mb-4">
                                        <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
