<?php

use common\models\Contact;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\search\ContactSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <p>
                <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success mt-5']) ?>
            </p>
            <div class="card">
                <div class="sa-divider"></div>
                <div class="container">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'language',
                            'address',
                            'tel_primary',
                            'tel_second',
                            'hours_work',
                            'coments',
                            'comment_two',
                            'work_time_short',
                            'email',
                            [
                                'class' => ActionColumn::class,
                                'urlCreator' => function ($action, Contact $model) {
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
