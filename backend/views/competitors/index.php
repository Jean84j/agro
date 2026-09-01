<?php

use backend\models\competitors\CompetitorPrice;
use backend\models\competitors\Competitors;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\search\CompetitorsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Competitors';
$this->params['breadcrumbs'][] = $this->title;

$competitorsName = CompetitorPrice::find()
    ->select('name')
    ->distinct()
    ->column();
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <?= $this->render('/_partials/breadcrumbs'); ?>
                    <div class="col-auto d-flex"><a href="<?= Url::to(['create']) ?>"
                                                    class="btn btn-primary"><?= Yii::t('app', 'New +') ?></a></div>
                </div>
            </div>
            <div class="card">
                <div class="p-4">
                    <input
                            type="text"
                            placeholder="<?= Yii::t('app', 'Start typing to search for statuses') ?>"
                            class="form-control form-control--search mx-auto"
                            id="table-search"
                    />
                </div>
                <div class="sa-divider"></div>
                <table class="sa-datatables-init" data-order='[[ 1, "asc" ]]' data-sa-search-input="#table-search">
                    <thead>
                    <tr>
                        <th><?= Yii::t('app', 'ID') ?></th>
                        <th><?= 'Img' ?></th>
                        <th class="min-w-10x"><?= Yii::t('app', 'name') ?></th>
                        <th class="min-w-10x"><?= Yii::t('app', 'price') ?></th>

                        <?php foreach ($competitorsName as $name): ?>
                            <?php $head = Competitors::getHeadCompetitors($name); ?>
                            <th class="">
                                <?php if ($head['image']): ?>
                                    <img src="<?= $head['image'] ?>" width="20" height="20" alt="<?= Html::encode($head['name']) ?>">
                                <?php endif; ?>
                                <?= Html::encode($head['name']) ?>
                            </th>
                        <?php endforeach; ?>

                        <th class="w-min" data-orderable="false"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dataProvider->models as $model): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="right"
                                     data-bs-custom-class="custom-tooltip"
                                    data-bs-title="<?= htmlspecialchars($model->product->category->name . ' | ' . $model->product->package) ?>">
                                    <span class="me-4"><?= $model->id ?></span>
                                    <span style="display: none;"><?= $model->product->category->name ?></span>
                                    <span style="display: none;"><?= $model->product->package ?></span>
                                </div>
                            </td>


                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="#" class="me-4">
                                        <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--size--lg">
                                            <img src="<?= $model->getImage($model->product->id) ?>"
                                                 width="40" height="40" alt=""/>
                                        </div>
                                    </a>
                                </div>
                            </td>

                            <td><a href="<?= Url::to(['update', 'id' => $model->id]) ?>"
                                   class="text-reset"><?= $model->product->name ?></a></td>
                            <td class="text-my_price"> <?= $model->product->price ?> </td>


                            <?php
                            $myPrice = (float)$model->product->price;
                            $pricesMap = $model->getCompetitorPricesMap($model->product_id);
                            $urlsMap = $model->getCompetitorUrlsMap($model->product_id);
                            ?>

                            <?php foreach ($competitorsName as $name): ?>
                                <?php
                                $price = $pricesMap[$name] ?? '❌';
                                $url = $urlsMap[$name] ?? '';
                                $priceClass = '';

                                if (is_numeric($price)) {
                                    $compPrice = (float)$price;
                                    if ($myPrice === $compPrice) {
                                        $priceClass = 'text-my_price';
                                    } elseif ($myPrice > $compPrice) {
                                        $priceClass = 'text-my_price_big';
                                    } else {
                                        $priceClass = 'text-my_price_small';
                                    }

                                    $price = number_format($compPrice, 2, '.', '');
                                }
                                ?>

                                <td>
                                    <?php if ($url): ?>
                                    <a href="<?= $url ?>" target="_blank" rel="noreferrer noopener"
                                       class="<?= $priceClass ?>">
                                        <?= $price ?>
                                    </a>
                                    <?php else: ?>
                                        <?= $price ?>
                                    <?php endif; ?>
                                </td>

                            <?php endforeach; ?>

                            <td>
                                <div class="dropdown">
                                    <button
                                            class="btn btn-sa-muted btn-sm"
                                            type="button"
                                            id="category-context-menu-0"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            aria-label="More"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="3" height="13"
                                             fill="currentColor">
                                            <path
                                                    d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z"
                                            ></path>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="category-context-menu-0">
                                        <li><a class="dropdown-item"
                                               href="<?php //Url::to(['category/remove-tag', 'id' => $model->id])?>"><?php //Yii::t('app', 'Remove tag')?></a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider"/>
                                        </li>
                                        <li>
                                            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], ['class' => "dropdown-item text-danger",
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post'
                                                ]
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
<style>
    .text-my_price {
        color: #0c8c28;
        font-weight: bold;
    }

    .text-my_price_big {
        color: #c50f49;
        font-weight: bold;
    }

    .text-my_price_small {
        color: #0f67c5;
        font-weight: bold;
    }

    .custom-tooltip .tooltip-inner {
        background-color: #3b4045; /* Цвет фона */
        color: #ffc107;            /* Цвет текста */
        font-size: 14px;           /* Размер шрифта */
        font-weight: 500;          /* Жирность */
        padding: 8px 12px;         /* Отступы */
        border-radius: 6px;        /* Скругление */
    }
</style>