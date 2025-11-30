<?php

use common\models\shop\ActivePages;
use frontend\assets\TagPageAsset;
use frontend\widgets\ViewProduct;
use yii\helpers\Url;

TagPageAsset::register($this);
ActivePages::setActiveUser();

/** @var frontend\controllers\TagController $categories */
/** @var frontend\controllers\TagController $page_description */

$symbol = '<span style="color: #de820b; font-size: 18px"># </span>';

?>
<div class="site__body">
    <div class="page-header">
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
                        <li class="breadcrumb-item active"
                            aria-current="page"><?= Yii::t('app', 'Всі теги сайту') ?></li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1><?= Yii::t('app', 'Список тегів') ?></h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="block">
            <div class="products-view">
                <hr class="hr-mod">
                <?php foreach ($categories as $category): ?>
                    <div style="margin: 15px; font-weight: bold; font-size: 24px; color: #47991f">
                        <?= $category['category']->name ?>
                    </div>
                    <div class="tags tags--lg">
                        <div class="tags__list">
                            <?php foreach ($category['tags'] as $tag): ?>
                                <a style="margin: 7px;"
                                   href="<?= Url::to(['tag/view', 'slug' => $tag->slug, 'category_slug' => $category['category']->slug]) ?>">
                                    <?= $symbol . $tag->name ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <hr class="hr-mod">
                <br>
                <div class="spec__disclaimer">
                    <?= $page_description ?>
                </div>
                <br>
                <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
            </div>
        </div>
    </div>
</div>
<style>
    .hr-mod {
        border: none;
        height: 3px;
        background-image: linear-gradient(to right, #FFF, #47991f, #FFF);
    }
</style>