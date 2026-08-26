<?php

use backend\models\competitors\Competitors;
use common\models\shop\Product;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Competitors\Competitors $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="competitors-form">
    <div id="top" class="sa-app__body">
        <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
            <div class="container container--max--xl">
                <div class="py-5">
                    <div class="row g-4 align-items-center">
                        <?= $this->render('/_partials/breadcrumbs'); ?>
                        <div class="col-auto d-flex">
                            <?php if (!$model->isNewRecord): ?>
                                <!--                            <a href="#" class="btn btn-secondary me-3">--><?php ////Yii::t('app', 'Duplicate')?><!--</a>-->
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
                                <div class="card-body p-5">
                                    <?= $this->render('/_partials/card-name-label', ['cardName' => 'Basic information']); ?>
                                    <div class="mb-4">

                                        <?php if ($model->isNewRecord): ?>

                                            <?php
                                            $subQuery = Competitors::find()->select('product_id');
                                            $data = ArrayHelper::map(Product::find()
                                                ->where(['not in', 'id', $subQuery])
                                                ->orderBy('id')
                                                ->asArray()
                                                ->all(), 'id', 'name');

                                            echo $form->field($model, 'product_id')->widget(Select2::class, [
                                                'data' => $data,
                                                'theme' => Select2::THEME_DEFAULT,
                                                'maintainOrder' => true,
                                                'pluginLoading' => false,
                                                'options' => [
                                                    'placeholder' => Yii::t('app', 'Select product...'),
                                                    'class' => 'sa-select2 form-select',
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'width' => '272px',
                                                ],
                                            ])->label(false);
                                            ?>

                                        <?php else: ?>

                                            <div class="form-group mb-3">
                                                <label class="form-label"><?= Yii::t('app', 'Product') ?></label>
                                                <p class="form-control-plaintext fw-bold">
                                                    <?= Html::encode($model->product->name ?? Yii::t('app', 'Not set')) ?>
                                                </p>
                                            </div>

                                            <?= $this->render('competitors-url/urls', [
                                                'model' => $model,
                                               'competitors' => $competitors,
                                            ]); ?>

                                        <?php endif; ?>


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
