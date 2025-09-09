<?php

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PostsReview $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(); ?>
    <div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container container--max--xl">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <?= $this->render('@backend/views/_partials/breadcrumbs'); ?>
                    <div class="col-auto d-flex">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout"
                 data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
                <div class="sa-entity-layout__body">
                    <div class="sa-entity-layout__main">
                        <div class="card">
                            <div class="card-body p-5">
                                <?= $this->render('/_partials/card-name-label', ['cardName' => 'Basic information']); ?>
                                <div class="row">
                                    <div class="col-4 mb-4">
                                        <?= $form->field($model, 'post_id')->textInput() ?>
                                    </div>
                                    <div class="col-4 mb-4">
                                        <?= $form->field($model, 'created_at')->textInput() ?>
                                    </div>
                                    <div class="col-2 mb-4">
                                        <?= $form->field($model, 'rating')->textInput() ?>
                                    </div>
                                    <div class="col-2 mb-4">
                                        <?= $form->field($model, 'viewed')->dropDownList(
                                            [
                                                1 => 'Так',
                                                0 => 'Ні'
                                            ]
                                        ) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-4">
                                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-6 mb-4">
                                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <?= $form->field($model, 'message')->textarea(['maxlength' => true, 'rows' => 6]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>