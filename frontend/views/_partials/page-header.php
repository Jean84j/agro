<?php

use frontend\widgets\BlockImages;
use yii\helpers\Url;

/** @var  $files */
/** @var  $h1 */
/** @var  $breadcrumbItemActive */

?>
<div class="page-header">
    <?php if (isset($files)): ?>
        <?php echo BlockImages::widget(['files' => $files,]) ?>
    <?php endif; ?>
    <div class="page-header__container container">
        <div class="page-header__breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/"> <i class="fas fa-home"></i> <?= Yii::t('app', 'Головна') ?></a>
                        <svg class="breadcrumb-arrow" width="6px" height="9px">
                            <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                        </svg>
                    </li>
                    <?php if (!empty($breadcrumbItems)): ?>
                        <?php foreach ($breadcrumbItems as $item): ?>
                            <?php
                            $url = !empty($item['slug'])
                                ? Url::to([$item['url'], 'slug' => $item['slug']])
                                : Url::to([$item['url']]);
                            ?>
                            <li class="breadcrumb-item">
                                <a href="<?= $url ?>" aria-label="<?= $item['item'] ?>">
                                    <?= Yii::t('app', $item['item']) ?>
                                </a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <li class="breadcrumb-item active"
                        aria-current="page"><?= Yii::t('app', $breadcrumbItemActive) ?>
                    </li>
                </ol>
            </nav>
        </div>
        <?php if (isset($h1)): ?>
            <div class="page-header__title">
                <h1><?= Yii::t('app', $h1) ?></h1>
            </div>
        <?php endif; ?>
    </div>
</div>
<style>
    .breadcrumb-arrow use {
        fill: rgba(255, 89, 0, 0.8) !important;
    }
</style>