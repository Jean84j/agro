<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\search\TagSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Tags');

?>
<div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container" style="max-width: 1623px">
            <div class="d-flex justify-content-end">
                <a href="<?= Url::to(['create']) ?>"
                   class="btn btn-primary mt-3 mb-3"><?= Yii::t('app', 'New +') ?></a></div>
            <div class="card">
                <div class="p-4">
                    <input
                            type="text"
                            placeholder="<?= Yii::t('app', 'Start typing to search for tags') ?>"
                            class="form-control form-control--search mx-auto"
                            id="table-search"
                    />
                </div>
                <div class="sa-divider"></div>
                <table class="sa-datatables-init" data-order='[[ 0, "asc" ]]' data-ordering='true'
                       data-sa-search-input="#table-search">
                    <thead style="background-color: rgba(244,135,46,0.93)">
                    <tr>

                        <th><?= Yii::t('app', 'ID') ?></th>
                        <th class="min-w-10x"><?= Yii::t('app', 'name') ?></th>
                        <th class="min-w-10x"><?= Yii::t('app', 'name_ru') ?></th>
                        <th class="min-w-15x"><?= Yii::t('app', 'categories') ?></th>
                        <th class="min-w-5x"><?= Yii::t('app', 'Count') ?></th>
                        <th class="w-min" data-orderable="false">D</th>
                        <th class="w-min" data-orderable="false">S</th>
                        <th class="w-min" data-orderable="false">V</th>
                        <th class="w-min" data-orderable="false"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dataProvider->models as $model): ?>

                        <?php foreach ($model->translations as $translation) {
                            if ($translation->language == 'ru') {
                                $name_ru = $translation->name;
                            }
                        } ?>

                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-4"><?= $model->id ?></span>
                                </div>
                            </td>
                            <td><a href="<?= Url::to(['tag/update', 'id' => $model->id]) ?>"
                                   class="text-reset"><?= $model->name ?></a></td>
                            <td><a href="<?= Url::to(['tag/update', 'id' => $model->id]) ?>"
                                   class="text-reset"><?= $name_ru ?></a></td>
                            <td> <?= $model->getCategoriesTag($model->id) ?> </td>
                            <td style="font-weight: bold">
                                <?= $model->getProductTag($model->id) ?> </td>
                            <td>
                                <?php if ($model->description != ''): ?>
                                    <svg width="20px" height="20px" style="display: unset;" fill="green">
                                        <use xlink:href="/admin/images/sprite.svg#check"/>
                                    </svg>
                                <?php else: ?>
                                    <svg width="20px" height="20px" style="display: unset;" fill="red">
                                        <use xlink:href="/admin/images/sprite.svg#cross"/>
                                    </svg>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($model->seo_title != ''): ?>
                                    <svg width="20px" height="20px" style="display: unset;" fill="green">
                                        <use xlink:href="/admin/images/sprite.svg#check"/>
                                    </svg>
                                <?php else: ?>
                                    <svg width="20px" height="20px" style="display: unset;" fill="red">
                                        <use xlink:href="/admin/images/sprite.svg#cross"/>
                                    </svg>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($model->visibility == false): ?>
                                    <svg width="22px" height="22px" style="display: unset;" fill="red">
                                        <use xlink:href="/admin/images/sprite.svg#eye-slash"/>
                                    </svg>
                                <?php else: ?>
                                    <svg width="22px" height="22px" style="display: unset;" fill="green">
                                        <use xlink:href="/admin/images/sprite.svg#eye"/>
                                    </svg>
                                <?php endif; ?>
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
                                        <svg width="3" height="13" style="display: unset">
                                            <use xlink:href="/admin/images/sprite.svg#drop-menu"/>
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
                                            <?= Html::a(Yii::t('app', 'Delete'), ['tag/delete', 'id' => $model->id], ['class' => "dropdown-item text-danger",
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
