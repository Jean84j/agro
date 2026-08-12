<?php

use common\models\shop\Product;
use yii\helpers\Html;
use yii\web\View;

/** @var Product $products */
/** @var Product $products_all */

$layout = Yii::$app->session->get('selectedLayout', 'grid-4-full');

?>
    <div class="view-options__layout">
        <div class="layout-switcher">
            <div class="layout-switcher__list">
                <button data-layout="grid-4-full"
                        data-with-features="false"
                        title="Плитка"
                        type="button"
                        class="layout-switcher__button <?= $layout === 'grid-4-full' ? 'layout-switcher__button--active' : '' ?>">
                    <svg width="16px" height="16px">
                        <use xlink:href="/images/sprite.svg#layout-grid-16x16"></use>
                    </svg>
                </button>
                <button data-layout="list"
                        data-with-features="false"
                        title="Список"
                        type="button"
                        class="layout-switcher__button <?= $layout === 'list' ? 'layout-switcher__button--active' : '' ?>">
                    <svg width="16px" height="16px">
                        <use xlink:href="/images/sprite.svg#layout-list-16x16"></use>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div class="view-options__legend"><?= Yii::t('app', 'Показано') ?>
        <span class="count-products"><?= count($products) ?></span>
        <?= Yii::t('app', 'товарів з') ?>
        <span class="count-products"><?= $products_all ?></span></div>
    <div class="view-options__divider"></div>
    <div class="view-options__control">
        <label for="sort-form"><?= Yii::t('app', 'Сортувати') ?></label>
        <div>
            <?php echo Html::dropDownList('sort', Yii::$app->session->get('sort'), [
                '' => Yii::t('app', 'Наявність'),
                'price_lowest' => Yii::t('app', 'Ціна Дешевші'),
                'price_highest' => Yii::t('app', 'Ціна Дорожчі'),
                'name_a' => Yii::t('app', 'Назва A-я'),
                'name_z' => Yii::t('app', 'Назва Я-а'),
            ], ['class' => 'form-control form-control-sm count-products', 'id' => 'sort-form']);
            ?>
        </div>
    </div>
    <div class="view-options__control">
        <label for="count-form"><?= Yii::t('app', 'Показати') ?></label>
        <div>
            <?php
            echo Html::dropDownList('count', Yii::$app->session->get('count'), [
                '4' => '4',
                '8' => '8',
                '12' => '12',
                '24' => '24',
                '32' => '32',
            ], ['class' => 'form-control form-control-sm count-products', 'id' => 'count-form']);
            ?>
        </div>
    </div>
    <style>
        .count-products {
            color: white;
            font-weight: bold;
            font-size: 17px;
            background-color: rgba(94, 180, 52, 0.78);
            padding: 0 5px;
            border-radius: 3px;
        }
    </style>
<?php
$script = <<< JS

$(document).ready(function () {
    $('#sort-form, #count-form').change(function () {
        this.form.submit();
    });
});

$(function () {
    $(document).on('click', '.layout-switcher__button', function () {
        var btn = $(this);
        
        if (btn.hasClass('layout-switcher__button--active')) {
            return;
        }
        
        var layout = btn.attr('data-layout');
        
        $('.layout-switcher__button').removeClass('layout-switcher__button--active');
        btn.addClass('layout-switcher__button--active');
        $('.products-list').attr('data-layout', layout);
        
        $.ajax({
            url: '/base-frontend/set-layout', 
            type: 'POST',
            data: {
                layout: layout,
                _csrf: yii.getCsrfToken()
            }
        });
    });
});

JS;

$this->registerJs($script, View::POS_END);
?>