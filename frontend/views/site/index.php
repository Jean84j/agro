<?php

/** @var yii\web\View $this */

use frontend\assets\HomePageAsset;
use frontend\widgets\BlockBrands;
use frontend\widgets\BlockPosts;
use frontend\widgets\ColumnsBestsellers;
use frontend\widgets\ColumnsSpecialOffers;
use frontend\widgets\ColumnsTopRated;
use frontend\widgets\ProductsCarouselGazon;
use frontend\widgets\ProductsCarousel;
use frontend\widgets\FeaturedProduct;
use frontend\widgets\BlockSlideshow;
use common\models\ActivePages;
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

        <div class="block block-product-columns d-lg-block d-none">
            <div class="container">
                <div class="row">
                    <?php echo ColumnsTopRated::widget() ?>
                    <?php echo ColumnsSpecialOffers::widget() ?>
                    <?php echo ColumnsBestsellers::widget() ?>
                </div>
            </div>
        </div>

        <?php if (Yii::$app->session->get('viewedProducts', [])) echo ViewProduct::widget() ?>
    </div>

<?= $this->render('index-description') ?>

<?php
$js = <<<JS
    
function initLazyWidgets() {
    var selectors = [
        '#bestsellers-container',
        '#popular-categories-container',
        '#bestsellers-dacha-container',
        
    ];

    var url = $('#url').attr('data-url') || $('#url').data('url');

    if (!url) {
        console.error('LazyLoad Error: Не найден URL в $("#url")');
        return;
    }

    var observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var container = entry.target;
                
                // Перестаем отслеживать
                observer.unobserve(container);

                var widgetName = $(container).data('widget');

                if (!widgetName) {
                    console.warn('LazyLoad Warning: Не указан data-widget у элемента', container);
                    return;
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: { widgetName: widgetName },
                    success: function(response) {
                        if (response && response.success) {
                            $(container).html(response.content);
                        } else {
                            console.error('LazyLoad Server Error:', response);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('LazyLoad AJAX Error:', textStatus, errorThrown);
                    }
                });
            }
        });
    }, {
        rootMargin: '200px 0px'
    });

    selectors.forEach(function(selector) {
        var el = document.querySelector(selector);
        if (el) {
            observer.observe(el);
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLazyWidgets);
} else {
    initLazyWidgets();
}

    
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