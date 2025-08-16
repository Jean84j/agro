<?php

use Detection\MobileDetect;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var common\models\shop\Order $model */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Замовлення', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container container--max--xl">
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
                        <h1 class="h3 m-0">Замовлення # <?= $model->id ?></h1>
                    </div>
                    <div class="col-auto d-flex">
                        <?php echo Html::a('Редагувати', Url::to(['update', 'id' => $model->id]), [
                            'class' => "btn btn-primary",
//                                'role' => 'modal-remote',
//                                'data-toggle' => 'tooltip'
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="sa-page-meta mb-5">
                <div class="sa-page-meta__body">
                    <div class="sa-page-meta__list">
                        <div class="sa-page-meta__item"><?= Yii::$app->formatter->asDatetime($model->created_at) ?></div>
                        <div class="sa-page-meta__item"> <?= $model->getTotalQty($model->id) ?> шт.</div>
                        <div class="sa-page-meta__item">
                            Сума <?= Yii::$app->formatter->asDecimal($model->getTotalSumm($model->id), 2) ?></div>
                        <div class="sa-page-meta__item">
                            Статус: <?= $model->getExecutionStatus($model->id) ?>
                        </div>
                        <div class="sa-page-meta__item">
                            Оплата: <?= $model->getPayMent($model->id) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout" data-sa-container-query='{"920":"sa-entity-layout--size--md"}'>
                <div class="sa-entity-layout__body">
                    <div class="sa-entity-layout__main">
                        <div class="card">
                            <div class="card-body px-5 py-4 d-flex align-items-center justify-content-between">
                                <h2 class="mb-0 fs-exact-18 me-4">Товари</h2>
                                <div class="text-muted fs-exact-14"><a href="#" data-bs-toggle="modal"
                                                                       data-bs-target="#addOrderItemModal"><i
                                                class="fas fa-plus"></i></a></div>
                            </div>
                            <?php echo $this->render('modal-add-product', ['model' => $model]); ?>
                            <?php if ($model->orderItems): ?>
                            <div class="table-responsive">
                                <table class="sa-table">
                                    <tbody>
                                    <?php $i = 1;
                                    foreach ($model->orderItems as $orderItem): ?>
                                        <tr>
                                            <td class="min-w-20x">
                                                <div class="d-flex align-items-center">

                                                    <?php $images = $orderItem->product->images;
                                                    $priorities = array_column($images, 'priority');
                                                    array_multisort($priorities, SORT_ASC, $images); ?>

                                                    <img src="/product/<?= $images[0]->name ?>"
                                                         class="me-4" width="40" height="40" alt=""/>
                                                    <span class="text-reset"><?= $orderItem->product->name ?></span>
                                                </div>
                                            </td>
                                            <td class="text-end"><?= $orderItem->quantity ?></td>
                                            <td class="text-end">
                                                <div class="sa-price">
                                                    <span class="sa-price__symbol"><?= Yii::$app->formatter->asDecimal($orderItem->price, 2) ?></span>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="sa-price" style="font-weight: bold">
                                                    <?= Yii::$app->formatter->asDecimal($orderItem->price * $orderItem->quantity, 2) ?>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="text-muted fs-exact-14">
                                                    <a href="#" data-bs-toggle="modal"
                                                       data-bs-target="#editOrderItemModal<?= $orderItem->id ?>">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                </div>
                                                <!-- Удаление товара из заказа -->
                                                <div class="text-muted fs-exact-14">
                                                    <a href="<?= Url::to(['order/delete-order-item', 'id' => $orderItem->id]) ?>"
                                                       class="text-danger"
                                                       onclick="return confirm('Вы уверены, что хотите удалить этот товар из заказа?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php echo $this->render('modal-edit-product', ['orderItem' => $orderItem]); ?>
                                        <?php $i++; endforeach; ?>
                                    </tbody>
                                    <tbody>
                                    <tr>
                                        <td colspan="3">Загальна сума</td>
                                        <td class="text-end">
                                            <div class="sa-price" style="font-weight: bold">
                                                <?= Yii::$app->formatter->asDecimal($model->getTotalSumm($model->id), 2) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="sa-entity-layout__sidebar">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                <h2 class="fs-exact-16 mb-0">Замовник</h2>
                                <?php
                                $det = new MobileDetect();
                                $device_mob = $det->isMobile();
                                if ($device_mob) {
                                    $znak = '%2B';
                                } else {
                                    $znak = '+';
                                }
                                $call = str_replace(array('(', ')', ' ', '+'), '', $model->phone);
                                $viberSms = 'viber://chat?number=' . $znak . $call;
                                $button3 = Html::a("<i class=\"fab fa-viber\"></i>", $viberSms, [
                                    'title' => 'Написать в Viber',
                                    'class' => 'pull-left detail-button',
                                    'style' => 'margin-right: 20px; font-size:22px; color:#7159e2;'
                                ]);
                                ?>
                                <div class="sa-page-meta__item" style="text-align: end;">
                                    <?= $button3 ?>
                                </div>
                            </div>
                            <div class="card-body pt-4 fs-exact-14">
                                <div></div>
                                <div class="text-muted mt-1">п.і.б.</div>
                                <div class="mt-1"><?= $model->fio ?></div>
                                <div class="text-muted mt-1">телефон</div>
                                <div class="mt-1"><?= $model->phone ?></div>
                                <?php if ($model->area): ?>
                                <div class="text-muted mt-1">область</div>
                                <div class="mt-1"><?= $model->area ?></div>
                                <div class="text-muted mt-1">місто</div>
                                <div class="mt-1"><?= $model->city ?></div>
                                <div class="text-muted mt-1">відділення</div>
                                <div class="mt-1"><?= $model->warehouses ?></div>
                                <?php elseif ($model->warehouses): ?>
                                    <div class="text-muted mt-1">індекс</div>
                                    <div class="mt-1"><?= $model->warehouses ?></div>
                                    <div class="text-muted mt-1">місто</div>
                                    <div class="mt-1"><?= $model->city ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card mt-5">
                            <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                <h2 class="fs-exact-16 mb-0"><span class="sa-nav__icon">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                   fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd"
        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg>
                                            </span> Коментар замовника
                                </h2>
                                <a href="#" class="fs-exact-14"></a>
                            </div>
                            <div class="card-body pt-4 fs-exact-14">
                                <div><?= $model->note ?? '' ?></div>
                            </div>
                        </div>
                        <div class="card mt-5">
                            <div class="card-body d-flex align-items-center justify-content-between pb-0 pt-4">
                                <h2 class="fs-exact-16 mb-0"><span class="sa-nav__icon">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                   fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd"
        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg>
                                            </span>Коментар менеджера
                                </h2>
                                <a href="#" class="fs-exact-14"></a>
                            </div>
                            <div class="card-body pt-4 fs-exact-14">
                                <div><?= $model->comment ?? '' ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => Modal::SIZE_EXTRA_LARGE,
//    'scrollable' => true,
    'options' => [
        "data-bs-backdrop" => "static",
        // "class" => 'modal-dialog-scrollable',
    ],
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
