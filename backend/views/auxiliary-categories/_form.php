<?php

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\shop\AuxiliaryCategories $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php
$form = ActiveForm::begin();

$params = [
    'form' => $form,
    'model' => $model,
];
if (isset($translateRu)) {
    $params['translateRu'] = $translateRu;
}
$tabs = $model->getTabs();
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container container--max--xl" style="max-width: 1623px">
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

                        <?= $this->render('@backend/views/_partials/tabs', ['tabs' => $tabs]); ?>

                        <div class="tab-content mt-4">
                            <?php foreach ($tabs as $tab): ?>
                                <div
                                        class="tab-pane fade <?= !empty($tab['active']) ? 'show active' : '' ?>"
                                        id="<?= $tab['id'] ?>-tab-content-1"
                                        role="tabpanel"
                                        aria-labelledby="<?= $tab['id'] ?>-tab-1"
                                >
                                    <?= $this->render($tab['view'], $params) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?= $this->render('sidebar', ['form' => $form, 'model' => $model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
