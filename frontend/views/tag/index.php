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

$h1 = 'Список тегів';
$breadcrumbItemActive = 'Всі теги сайту';

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'h1' => $h1,
            'breadcrumbItemActive' => $breadcrumbItemActive,
        ]) ?>
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