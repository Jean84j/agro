<?php

use common\models\shop\MinimumOrderAmount;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\MinimumOrderAmountSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Minimum Order Amounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
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
                                ]); ?>
                            </ol>
                        </nav>
                    </div>
                    <?php if (!MinimumOrderAmount::find()->exists()): ?>
                        <div class="col-auto d-flex">
                            <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">
                                <?= Yii::t('app', 'Create Minimum Order Amount') ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'amount',
                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, MinimumOrderAmount $model) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>