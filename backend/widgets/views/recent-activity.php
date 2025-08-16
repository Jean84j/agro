<?php

use yii\helpers\Html;

?>
<div class="col-12 col-lg-6 d-flex">
    <div class="card flex-grow-1">
        <div class="card-body">
            <div class="sa-widget-header mb-4">
                <h2 class="sa-widget-header__title"><?= $titleWidget ?></h2>
                <div class="sa-widget-header__actions">
                    <div class="dropdown">
                        <button
                                type="button"
                                class="btn btn-sm btn-sa-muted d-block"
                                id="widget-context-menu-8"
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
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="widget-context-menu-8">
                            <li><?= Html::a(Yii::t('app', 'All products'), ['product/activity-product'], ['class' => 'dropdown-item']) ?>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                <?php $i = 0;
                foreach ($results as $value): ?>
                    <?php $url = strtok($value['slug'], '?'); ?>
                    <li class="list-group-item py-2">
                        <div class="d-flex align-items-center py-3">
                            <a href="/<?= $catalog ?>/<?= $url ?>" target="_blank" class="me-4">
                                <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--size--lg">
                                    <?php if (isset($value['image'])): ?>
                                        <img src="/<?= $catalogImage ?>/<?= $value['image'] ?>"
                                             width="40"
                                             height="40" alt=""/>
                                    <?php else: ?>
                                        <img src="/images/no-image.png"
                                             width="40"
                                             height="40" alt=""/>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="d-flex align-items-center flex-grow-1 flex-wrap">

                                <div class="col">
                                    <a href="/<?= $catalog ?>/<?= $url ?>" target="_blank"
                                       class="text-reset fs-exact-14">
                                        <?= isset($value['name']) ?
                                            (mb_strlen($value['name']) > 45 ? mb_substr($value['name'], 0, 45) . '...' : $value['name'])
                                            : 'Без назви' ?>
                                    </a>
                                    <div class="text-muted fs-exact-13">
                                        <?= $icon ?? '<i class="fas fa-eye"></i>' ?>
                                        <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user">
                                            <?= (int)$value['count'] ?>
                                        </span>
                                        <?php if (!empty($value['date_public'])): ?>
                                            | <i class="fas fa-indent"></i>
                                            <span><?= Yii::$app->formatter->asDate($value['date_public'], 'php:d.m.Y') ?></span>
                                        <?php endif; ?>

                                        <?php if (!empty($value['date_updated'])): ?>
                                            | <i class="fas fa-edit"></i>
                                            <span><?= Yii::$app->formatter->asDate($value['date_updated'], 'php:d.m.Y') ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-auto">
                                    <div class="sa-rating ms-sm-3 my-2 my-sm-0">
                                        <?= !empty($value['date']) ? Yii::$app->formatter->asDatetime($value['date'], 'medium') : '' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
