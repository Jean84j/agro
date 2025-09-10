<?php

use common\models\Slider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\SliderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Sliders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <?= $this->render('@backend/views/_partials/breadcrumbs'); ?>
                    <div class="col-auto d-flex"><a href="<?=Url::to(['create'])?>" class="btn btn-primary"><?=Yii::t('app', 'Create Slider')?></a></div>
                </div>
            </div>
            <div class="card">
                <div class="sa-divider"></div>
                <div class="container">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'image',
                            'format' => 'html',
                            'value' => function ($model) {
                                return Html::img(Yii::$app->request->hostInfo . '/images/slider/' .$model->image, ['width' => '150px']);
                            },
                        ],
                        'title',
                        'description:raw',
                        'visible:boolean',
                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, Slider $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
                 </div>
            </div>
        </div>
    </div>
</div>