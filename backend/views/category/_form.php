<?php

use yii\bootstrap5\Breadcrumbs;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\shop\Category $model */
/** @var ActiveForm $form */
?>

<?php
$form = ActiveForm::begin();

$params = [
    'form' => $form,
    'model' => $model,

    'seoTitle' => 'pageTitle',
    'seoDescription' => 'metaDescription',
    'seoH1' => 'h1',
    'seoTitleRu' => 'pageTitle',
    'seoDescriptionRu' => 'metaDescription',
    'seoH1Ru' => 'h1',

    'header' => 'Image 231 x 231',
    'dir' => Yii::$app->request->hostInfo . '/images/category/' . $model->file,
    'file' => 'file',
];
if (isset($translateRu)) {
    $params['translateRu'] = $translateRu;
}
$tabs = $model->getTabs();
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container container--max--xl" style="max-width: 1623px">
            <div class="pt-3">
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
                        <?php if (!$model->isNewRecord): ?>
                            <?= Html::a(Yii::t('app', 'List category'), Url::to(['index']), ['class' => 'btn btn-secondary me-3']) ?>
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
                        <?= $this->render('@backend/views/_partials/tabs', ['tabs' => $tabs, 'params' => $params]); ?>
                    </div>
                    <?= $this->render('sidebar', ['form' => $form, 'model' => $model, 'params' => $params]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

