<?php

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SeoPages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php
$form = ActiveForm::begin(['options' => ['autocomplete' => "off"]]);
$commonParams = [
    'model' => $model,
    'form' => $form,

    'seoTitle' => 'title',
    'seoDescription' => 'description',
    'seoH1' => 'h1',
    'seoTitleRu' => 'title',
    'seoDescriptionRu' => 'description',
    'seoH1Ru' => 'h1',
];
if (isset($translateRu)) {
    $commonParams['translateRu'] = $translateRu;
}

$tabs = $model->getTabs();
?>
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

                        <?= $this->render('/_partials/tabs', ['tabs' => $tabs, 'params' => $commonParams]); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

