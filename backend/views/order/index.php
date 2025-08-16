<?php

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\search\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Замовлення';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
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
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]);
                                ?>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-auto d-flex"><a href="<?=Url::to(['create'])?>" class="btn btn-primary"><?=Yii::t('app', 'New order')?></a></div>
                </div>
            </div>
            <div class="card">
                <div class="p-4">
                    <input
                            type="text"
                            placeholder="<?=Yii::t('app', 'Start typing to search for categories')?>"
                            class="form-control form-control--search mx-auto"
                            id="table-search"
                    />
                </div>
                <div class="sa-divider"></div>
                <table class="sa-datatables-init text-nowrap" data-order='[[ 1, "desc" ]]' data-sa-search-input="#table-search">
                    <thead>
                    <tr>
                        <th class="w-min" data-orderable="false">
                            <input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="..." />
                        </th>
                        <th>№</th>
                        <th>Статус</th>
                        <th>Замовник</th>
                        <th>Дата</th>
                        <th>Оплата</th>
                        <th>К-ть</th>
                        <th>Заг. сума</th>
                        <th>Постачальник</th>
                        <th class="w-min" data-orderable="false"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dataProvider->models as $order): ?>
                    <tr>
                        <td><input type="checkbox" class="form-check-input m-0 fs-exact-16 d-block" aria-label="..." /></td>
                        <td><a href="<?=Url::to(['order/view', 'id' => $order->id])?>" class="text-reset"><?=$order->id?></a></td>
                        <td>
                            <div class="d-flex fs-6"><?=$order->getExecutionStatus($order->id)?></div>
                        </td>
                        <td><a href="<?=Url::to(['order/view', 'id' => $order->id])?>" class="text-reset"><?=$order->fio?></a></td>
                        <td><?=Yii::$app->formatter->asDatetime($order->created_at)?></td>
                        <td>
                            <div class="d-flex fs-6"><?=$order->getPayMent($order->id)?></div>
                        </td>
                        <td><?=Yii::$app->formatter->asDecimal($order->getTotalQty($order->id), 0)?>
                        </td>
                        <td>
                            <div class="sa-price">
                                <?=Yii::$app->formatter->asDecimal($order->getTotalSumm($order->id), 2)?>
                            </div>
                        </td>
                        <td><?= $order->getProvider($order->order_provider_id)?></td>
                        <td>
                            <div class="dropdown">
                                <button
                                        class="btn btn-sa-muted btn-sm"
                                        type="button"
                                        id="order-context-menu-0"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        aria-label="More"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="3" height="13" fill="currentColor">
                                        <path
                                                d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z"
                                        ></path>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="order-context-menu-0">
<!--                                    <li><a class="dropdown-item" href="#">Edit</a></li>-->
<!--                                    <li><a class="dropdown-item" href="#">Duplicate</a></li>-->
<!--                                    <li><a class="dropdown-item" href="#">Add tag</a></li>-->
<!--                                    <li><a class="dropdown-item" href="#">Remove tag</a></li>-->
<!--                                    <li><hr class="dropdown-divider" /></li>-->
                                    <li>
                                        <?= Html::a(Yii::t('app', 'View'), ['order/view', 'id' => $order->id], [
                                            'class' => 'dropdown-item text-info',
                                        ]) ?>
                                    </li>
                                    <li>
                                        <?= Html::a(Yii::t('app', 'Update'), ['order/update', 'id' => $order->id], [
                                            'class' => 'dropdown-item text-warning',
                                        ]) ?>
                                    </li>
                                    <li>
                                        <?= Html::a(Yii::t('app', 'Delete'), ['order/delete', 'id' => $order->id], [
                                            'class' => 'dropdown-item text-danger',
                                            'data' => [
                                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>