<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\shop\Tag $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tag-form">
    <?php $form = ActiveForm::begin(); ?>
    <div id="top" class="sa-app__body">
        <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
            <div class="container container--max--xl">
                <div class="py-5">
                    <div class="row g-4 align-items-center">
                        <?= $this->render('/_partials/breadcrumbs'); ?>
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
                                <div class="card-body p-5">
                                    <div class="mb-5"><h2
                                                class="mb-0 fs-exact-18"><?= Yii::t('app', 'Basic information') ?></h2>
                                    </div>
                                    <div class="mb-4">
                                        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(Yii::t('app', 'name')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (isset($products)): ?>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Фото</th>
                                    <th scope="col">Товар</th>
                                    <th scope="col">Статус</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;
                                foreach ($products as $product): ?>
                                    <?php switch ($product->status_id) {
                                        case 1:
                                            $color = 'success';
                                            break;
                                        case 2:
                                            $color = 'danger';
                                            break;
                                        case 3:
                                            $color = 'warning';
                                            break;
                                        case 4:
                                            $color = 'info';
                                            break;

                                        default:
                                            $color = 'secondary';
                                    } ?>

                                    <tr>
                                        <td><?= $i ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="me-4">
                                                    <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--size--lg">
                                                        <img src="<?= isset($product->images[0])
                                                            ? Url::to('/product/' . $product->images[0]->extra_small, true)
                                                            : Url::to('/images/no-image.png', true) ?>"
                                                             width="40" height="40" alt=""/>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>

                                        <td>
                                            <?php
                                            $url = Url::to(['product/update', 'id' => $product->id]);
                                            ?>
                                            <a href="<?= $url ?>" class="text-reset" style="font-weight: bold;">
                                                <?= $product->name ?>
                                            </a>
                                        </td>

                                        <td><?= '<div class="badge badge-sa-' . $color . '">' . $product->status->name ?? '—' . '</div>' ?></td>

                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
