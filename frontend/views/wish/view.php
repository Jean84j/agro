<?php

use common\models\shop\ActivePages;
use frontend\assets\WishListPageAsset;
use frontend\widgets\ProductsCarousel;
use frontend\widgets\ViewProduct;

/** @var  $products */
/** @var  $page_description */
/** @var  $properties */

ActivePages::setActiveUser();
WishListPageAsset::register($this);

$h1 = 'Список бажань';
$breadcrumbItemActive = 'Список бажань';

?>
    <div class="site__body">
        <?= $this->render('/_partials/page-header',
            [
                'h1' => $h1,
                'breadcrumbItemActive' => $breadcrumbItemActive,

            ]) ?>
        <div id="wish-list">
            <?= $this->render('_wishlist', ['products' => $products]) ?>
        </div>
        <div class="container spec__disclaimer">
            <?= $page_description ?>
        </div>
        <?php echo ProductsCarousel::widget() ?>
        <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
    </div>
<?php
$script = <<< JS
    $(document).on('click', '#delete-from-wish-btn', function(e) {
    e.preventDefault();
    var wishIndicator = $('#wish-indicator');
    var wishListContainer = $('#wish-list');
    var productId = $(this).data('wish-product-id');
    var url = $(this).data('url-wish');
    $.ajax({
        url: url,
        type: 'POST',
        data: { id: productId },
        success: function(response) {
    if (response.success) {
        wishListContainer.html(response.wishListHtml);
        wishIndicator.text(response.wishCount);
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