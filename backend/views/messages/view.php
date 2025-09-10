<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Messages $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container container--max--xl">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <?= $this->render('@backend/views/_partials/breadcrumbs'); ?>
                    <div class="col-auto d-flex">
                        <?= Html::a(Yii::t('app', 'List reviews'), Url::to(['index']), ['class' => 'btn btn-secondary me-3']) ?>
                        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary me-3']) ?>
                        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post'
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout" data-sa-container-query='{"920":"sa-entity-layout--size--md","1100":"sa-entity-layout--size--lg"}'>
                <div class="sa-entity-layout__body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
//                            'id',
                            [
                                'attribute' => 'created_at',
                                'filter' => false,
                                'value' => function($model){
                                    return Yii::$app->formatter->asDate($model->created_at, 'long');
                                },
                            ],
                            'name',
                            'email:email',
                            'subject',
                            'message:raw',
                            'comment:raw',
                            'viewed:boolean',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>