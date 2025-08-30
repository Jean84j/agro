<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\shop\Tag $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php
$form = ActiveForm::begin();

$commonParams = [
    'model' => $model,
    'form' => $form,
    'seoTitle' => 'seo_title',
    'seoDescription' => 'seo_description',
    'seoH1' => 'h1',
    'seoTitleRu' => 'seo_title',
    'seoDescriptionRu' => 'seo_description',
    'seoH1Ru' => 'h1',
];
if (isset($translateRu)) {
    $commonParams['translateRu'] = $translateRu;
}
?>
<div class="tag-form">
    <div id="top" class="sa-app__body">
        <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
            <div class="container">
                <div class="d-flex justify-content-end">
                    <?php if (!$model->isNewRecord): ?>
                        <?= Html::a(Yii::t('app', 'List'), Url::to(['index']), ['class' => 'btn btn-secondary me-3 mb-3 mt-3']) ?>
                        <?= Html::a(Yii::t('app', 'Create more'), Url::to(['create']), ['class' => 'btn btn-success me-3 mb-3 mt-3']) ?>
                    <?php endif; ?>
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary mb-3 mt-3']) ?>
                </div>
                <div class="sa-entity-layout"
                     data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
                    <div class="sa-entity-layout__body">
                        <div class="sa-entity-layout__main">
                            <?= $this->render('basic-information', $commonParams) ?>
                            <?php echo $this->render('/_partials/seo-information', $commonParams); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


