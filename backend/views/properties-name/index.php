<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\search\PropertiesName $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-auto d-flex"><a href="<?=Url::to(['create'])?>" class="btn btn-primary"><?=Yii::t('app', 'New +')?></a></div>
                </div>
            </div>
            <div class="card">
                <div class="p-4">
                    <input
                            type="text"
                            placeholder="<?=Yii::t('app', 'Start typing to search for statuses')?>"
                            class="form-control form-control--search mx-auto"
                            id="table-search"
                    />
                </div>
                <div class="sa-divider"></div>
                <table class="sa-datatables-init" data-order='[[ 4, "asc" ]]' data-ordering='true' data-sa-search-input="#table-search">
                    <thead style="background-color: rgba(244,135,46,0.93)">
                    <tr>
                        <th><?=Yii::t('app', 'ID')?></th>
                        <th class="min-w-10x"><?=Yii::t('app', 'Name UK')?></th>
                        <th class="min-w-10x"><?=Yii::t('app', 'Name RU')?></th>
                        <th class="w-min"><?=Yii::t('app', 'Sort')?></th>
                        <th class="min-w-10x"><?=Yii::t('app', 'Category')?></th>
                        <th class="min-w-10x"><?=Yii::t('app', 'Products')?></th>
                        <th class="w-min" data-orderable="false"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dataProvider->models as $model): ?>
                        <?php foreach ($model->translations as $translation) {
                            if ($translation->language == 'ru') {
                                $name_ru = $translation->name;
                            } else {
                                $name_en = $translation->name;
                            }
                        } ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-4"><?=$model->id?></span>
                                </div>
                            </td>
                            <td><a href="<?=Url::to(['update', 'id' => $model->id])?>" class="text-reset"><?= $model->name ?></a></td>
                            <td><a href="<?=Url::to(['update', 'id' => $model->id])?>" class="text-reset"><?= $name_ru ?></a></td>
                            <td> <?= $model->sort ?> </td>
                            <td> <?= $model->getCategoriesProperty($model->id) ?> </td>
                            <td> <?= $model->getProductCountProperty($model->id) ?> </td>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="3" height="13" fill="currentColor">
                                            <path
                                                    d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z"
                                            ></path>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="category-context-menu-0">
                                        <li><a class="dropdown-item" href="<?php //Url::to(['category/remove-tag', 'id' => $model->id])?>"><?php //Yii::t('app', 'Remove tag')?></a></li>
                                        <li><hr class="dropdown-divider" /></li>
                                        <li>
                                            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], ['class'=>"dropdown-item text-danger",
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
