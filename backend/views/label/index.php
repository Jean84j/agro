<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\search\LabelSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Labels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <?= $this->render('@backend/views/_partials/breadcrumbs'); ?>
                    <div class="col-auto d-flex">
                        <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">
                            <?= Yii::t('app', 'New +') ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="p-4">
                    <input
                            type="text"
                            placeholder="<?= Yii::t('app', 'Start typing to search for labels') ?>"
                            class="form-control form-control--search mx-auto"
                            id="table-search"
                    />
                </div>
                <div class="sa-divider"></div>
                <table class="sa-datatables-init" data-order='[[ 1, "asc" ]]' data-sa-search-input="#table-search">
                    <thead>
                    <tr>
                        <th><?= Yii::t('app', 'ID') ?></th>
                        <th class="min-w-15x"><?= Yii::t('app', 'name') ?></th>
                        <th class="min-w-15x"><?= Yii::t('app', 'Count') ?></th>
                        <th class="min-w-15x"><?= Yii::t('app', 'Color') ?></th>
                        <th class="w-min" data-orderable="false"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dataProvider->models as $model): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-4"><?= $model->id ?></span>
                                </div>
                            </td>
                            <td>
                                <a href="<?= Url::to(['label/update', 'id' => $model->id]) ?>" class="text-reset">
                                    <div class="product-card__badges-list">
                                        <div class="product-card__badge product-card__badge--new"
                                             style="background: <?= Html::encode($model->color) ?>;">
                                            <?= $model->name ?>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <?= $model->getProductLabel($model->id) ?>
                            </td>
                            <td>
                                <div style="width: 20px; height: 20px; background-color: <?= $model->color ?>; border: 1px solid #000;"></div>
                            </td>

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
    .product-card__badges-list {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
        z-index: 1;
    }

    .product-card__badge--new {
        background: #3377ff;
        color: #fff;
    }

    .product-card__badge {
        font-size: 11px;
        border-radius: 2px;
        letter-spacing: 0.02em;
        line-height: 1;
        padding: 5px 8px 4px;
        font-weight: 500;
        text-transform: uppercase;
    }
</style>
