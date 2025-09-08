<?php

use vova07\imperavi\Widget;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Slider $model */
/** @var yii\widgets\ActiveForm $form */

?>
<?php
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

$params = [
    'form' => $form,
    'model' => $model,

    'header' => 'Image 840 x 395',
    'dir' => Yii::$app->request->hostInfo . '/images/slider/' . $model->image,
    'file' => 'image',
];

$mobParams = [
    'form' => $form,
    'model' => $model,

    'header' => 'Image 510 x 395',
    'dir' => Yii::$app->request->hostInfo . '/images/slider/' . $model->image_mob,
    'file' => 'image_mob',
];
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container container--max--xl">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <nav class="mb-2" aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-sa-simple">
                                <?php echo Breadcrumbs::widget([
                                    'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                                    'homeLink' => [
                                        'label' => Yii::t('app', 'Home'),
                                        'url' => Yii::$app->homeUrl,
                                    ],
                                    'links' => $this->params['breadcrumbs'] ?? [],
                                ]);
                                ?>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-auto d-flex">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
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
                                    <div class="col-5 mb-4">
                                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-5 mb-4">
                                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-2 mb-4">
                                        <?= $form->field($model, 'visible')->dropDownList(
                                            [
                                                1 => 'Так',
                                                0 => 'Ні'
                                            ]
                                        ) ?>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <?= $form->field($model, 'description')->widget(Widget::class, [
                                        'defaultSettings' => [
                                            'style' => 'position: unset;'
                                        ],
                                        'settings' => [
                                            'lang' => 'uk',
                                            'minHeight' => 100,
                                            'plugins' => [
                                                'fullscreen',
                                                'table',
                                            ],
                                        ],
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-5">
                            <div class="row card-body p-5">
                                <div class="col-6">
                                    <?= $this->render('/_partials/image-upload', $params) ?>
                                </div>
                                <div class="col-6">
                                    <?= $this->render('/_partials/image-upload', $mobParams) ?>
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
