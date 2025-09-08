<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\shop\PropertiesName $model */
/** @var yii\widgets\ActiveForm $form */

?>

<?php $form = ActiveForm::begin(); ?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container container--max--xl">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-auto d-flex">
                        <?php if (!$model->isNewRecord): ?>
                            <?= Html::a(Yii::t('app', 'List'), Url::to(['index']), ['class' => 'btn btn-secondary me-3']) ?>
                            <?= Html::a(Yii::t('app', 'Create more'), Url::to(['create']), ['class' => 'btn btn-success me-3']) ?>
                        <?php endif; ?>
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout"
                 data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
                <div class="sa-entity-layout__body">
                    <div class="sa-entity-layout__main">
                        <div class="card">
                            <?php
                            $commonParams = ['model' => $model, 'form' => $form];
                            if (isset($translateRu)) {
                                $commonParams['translateRu'] = $translateRu;
                            }
                            ?>
                            <div class="card-body p-5">
                                <?= $this->render('/_partials/card-name-label', ['cardName' => 'Basic information']); ?>
                                <div class="row">
                                    <div class="col-9">
                                        <div class="mb-4">
                                            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(Yii::t('app', 'name UK')) ?>
                                        </div>
                                        <div class="mb-4">
                                            <?php if (isset($translateRu)): ?>
                                                <?= $form->field($translateRu, 'name')->textInput([
                                                    'maxlength' => true,
                                                    'id' => 'translateRu-name',
                                                    'name' => 'PropertyTranslate[ru][name]'
                                                ])->label(Yii::t('app', 'name RU')) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-4">
                                            <?= $form->field($model, 'sort')->textInput(['maxlength' => true])->label(Yii::t('app', 'sort')) ?>
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
</div>
<?php ActiveForm::end(); ?>