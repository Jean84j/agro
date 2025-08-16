<?php

/** @var yii\web\View $this */

use frontend\assets\HomePageAsset;
use frontend\widgets\BlockBrands;
use frontend\widgets\BlockPosts;
use frontend\widgets\ProductsCarouselGazon;
use frontend\widgets\ProductsCarousel;
use frontend\widgets\FeaturedProduct;
use frontend\widgets\BlockSlideshow;
use common\models\shop\ActivePages;
use frontend\widgets\BlockFeatures;
use frontend\widgets\BlockBanner;
use frontend\widgets\ViewProduct;

HomePageAsset::register($this);
ActivePages::setActiveUser();

?>
    <div class="site__body">
        <?php echo BlockSlideshow::widget() ?>
        <?php echo BlockFeatures::widget() ?>
        <?php echo ProductsCarouselGazon::widget() ?>
        <?php echo FeaturedProduct::widget() ?>
        <?php echo BlockBanner::widget() ?>
        <div id="url" data-url="<?= Yii::$app->urlManager->createUrl(['site/load-content']) ?>"></div>
        <div id="bestsellers-container" data-widget="bestsellers"></div>
        <div id="popular-categories-container" data-widget="popular-categories"></div>
        <div id="bestsellers-dacha-container" data-widget="bestsellers-dacha"></div>
        <?php echo ProductsCarousel::widget() ?>
        <?php echo BlockPosts::widget() ?>
        <?php echo BlockBrands::widget() ?>
        <div id="columns-container" data-widget="columns"></div>
        <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
    </div>

<?= $this->render('index-description') ?>

<?php
$js = <<<JS
    
var containersInfo = [
    { selector: '#bestsellers-container', loaded: false },
    { selector: '#popular-categories-container', loaded: false },
    { selector: '#bestsellers-dacha-container', loaded: false },
    { selector: '#columns-container', loaded: false }
];

function loadContent(containerInfo, containerTop) {
    if ($(window).scrollTop() >= containerTop - $(window).height() && !containerInfo.loaded) {
        var widgetName = $(containerInfo.selector).data('widget');
        var url = $('#url').attr('data-url');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { widgetName: widgetName },
            success: function(response) {
                if (response.success && !containerInfo.loaded) {
                    $(containerInfo.selector).append(response.content);
                    containerInfo.loaded = true;
                }
            }
        });
    }
}

$(window).scroll(function() {
    containersInfo.forEach(function(containerInfo) {
        var containerTop = $(containerInfo.selector).offset().top;
        loadContent(containerInfo, containerTop);
    });
});

    
   $(document).ready(function () {
        var fullDescription = $('.full-description');
        var showMoreBtn = $('#show-more-btn');
        var hideDescriptionBtn = $('#hide-description-btn');
        fullDescription.hide();
        showMoreBtn.click(function () {
            fullDescription.fadeIn();
             hideDescriptionBtn.show();
            showMoreBtn.hide();
        });
        hideDescriptionBtn.click(function () {
            fullDescription.fadeOut();
            hideDescriptionBtn.hide();
            showMoreBtn.show();
        });
    });

JS;
$this->registerJs($js);
?>