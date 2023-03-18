<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var common\models\Delivery $model */
/** @var yii\widgets\ActiveForm $form */
?>

<!--<div class="delivery-form">-->
<!---->
<!--    --><?php //$form = ActiveForm::begin(); ?>
<!---->
<!--    --><?//= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?//= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
<!---->
<!--    <div class="form-group">-->
<!--        --><?//= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
<!--    </div>-->
<!---->
<!--    --><?php //ActiveForm::end(); ?>
<!---->
<!--</div>-->

<?php $form = ActiveForm::begin(['options' => ['autocomplete'=>"off"]]); ?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <nav class="mb-2" aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-sa-simple">
                                <?php
                                echo Breadcrumbs::widget([
                                    'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                                    'homeLink' => [
                                        'label' => 'Главная ',
                                        'url' => Yii::$app->homeUrl,
                                    ],
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]);
                                ?>
                            </ol>
                        </nav>
                        <h1 class="h3 m-0"><?= $this->title ?></h1>
                    </div>

                    <div class="col-auto d-flex">
                        <?php if(!$model->isNewRecord): ?>
                            <!--                            <a href="#" class="btn btn-secondary me-3">--><?php ////Yii::t('app', 'Duplicate')?><!--</a>-->
                            <?php // Html::a(Yii::t('app', 'List'), Url::to(['index']), ['class' => 'btn btn-secondary me-3']) ?>
                            <?php // Html::a(Yii::t('app', 'Create more'), Url::to(['create']), ['class' => 'btn btn-success me-3']) ?>
                        <?php endif; ?>
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout" data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
                <div class="sa-entity-layout__body">
                    <div class="sa-entity-layout__main">
                        <div class="card">
                            <div class="card-body p-5">
                                <div class="mb-5">
                                    <h2 class="mb-0 fs-exact-18">Основна інформація</h2>
                                </div>

                                <div class="mb-4">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                                </div>

                                <div class="mb-4">
                                    <!-- sa-quill-control  -->
                                    <?= $form->field($model, 'description')->widget(Widget::class, [
                                        'defaultSettings' => [
                                            'style' => 'position: unset;'
                                        ],
                                        'settings' => [
                                            'lang' => 'uk',
                                            'minHeight' => 100,
                                            'plugins' => [
//                'clips',
                                                'fullscreen',
                                                'table',
                                            ],
//            'clips' => [
//                ['Не вкл', 'Не включается'],
//                ['Не раб', 'Не работает'],
//                ['Протекает', 'Протекает'],
//                ['Шумит', 'Посторонний шум'],
//            ],
                                        ],
                                    ]);?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

