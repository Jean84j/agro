<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Contact $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
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
                                <div class="col-3 mb-4">
                                    <?= $form->field($model, 'tel_primary')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-3 mb-4">
                                    <?= $form->field($model, 'tel_second')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-3 mb-4">
                                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-3 mb-4">
                                    <?= $form->field($model, 'language')->dropDownList(
                                        [
                                            'en' => 'English',
                                            'ru' => 'Русский',
                                            'uk' => 'Українська'
                                        ],
                                    ) ?>
                                </div>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($model, 'hours_work')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($model, 'coments')->textarea(['maxlength' => true,'rows' => 6]) ?>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($model, 'comment_two')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($model, 'work_time_short')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


