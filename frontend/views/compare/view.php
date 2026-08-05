<?php

use common\models\shop\ActivePages;
use frontend\assets\ComparePageAsset;
use frontend\widgets\ProductsCarousel;
use frontend\widgets\ViewProduct;

/** @var  $products */
/** @var  $page_description */
/** @var  $properties */

ComparePageAsset::register($this);
ActivePages::setActiveUser();

$h1 = 'Порівняння товарів';
$breadcrumbItemActive = 'Порівняння';

?>
<div class="site__body">
    <?= $this->render('/_partials/page-header',
        [
            'h1' => $h1,
            'breadcrumbItemActive' => $breadcrumbItemActive,

        ]) ?>
    <div id="compare-list">
        <?= $this->render('_compareList',
            [
                'properties' => $properties,
                'products' => $products,
            ]) ?>
    </div>
    <div class="container spec__disclaimer">
        <?= $page_description ?>
    </div>
    <?php echo ProductsCarousel::widget() ?>
    <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
</div>

<?php
$script = <<< JS
    $(document).on('click', '#delete-from-compare-btn', function(e) {
    e.preventDefault();
    var compareIndicator = $('#compare-indicator');
    var compareListContainer = $('#compare-list');
    var productId = $(this).data('compare-product-id');
    var url = $(this).data('url-compare');
    $.ajax({
        url: url,
        type: 'POST',
        data: { id: productId },
        success: function(response) {
    if (response.success) {
        compareListContainer.html(response.compareListHtml);
        compareIndicator.text(response.compareCount);
    } else {
        console.log('Произошла ошибка при удалении товара из списка сравнения')
    }
},
        error: function() {
            console.log('Произошла ошибка при выполнении AJAX-запроса')
        }
    });
});
JS;
$this->registerJs($script);
?>
