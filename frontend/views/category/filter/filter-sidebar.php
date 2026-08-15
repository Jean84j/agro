<?php

/** @var $category */
/** @var $propertiesFilter */
/** @var $categoryMinPrice */
/** @var $categoryMaxPrice */
/** @var $minPrice */
/** @var $maxPrice */
/** @var $filterBrandsItem */
/** @var $category_products_all */
/** @var $products_all */

use yii\web\View;

?>
    <div class="block block-sidebar block-sidebar--offcanvas--mobile">
        <div class="block-sidebar__backdrop"></div>
        <div class="block-sidebar__body">
            <div class="block-sidebar__header">
                <div class="block-sidebar__title"><?= Yii::t('app', 'Фільтр') ?></div>
                <button class="block-sidebar__close" type="button">
                    <svg width="20px" height="20px">
                        <use xlink:href="/images/sprite.svg#cross-20"></use>
                    </svg>
                </button>
            </div>
            <div class="block-sidebar__item">
                <div class="widget-filters widget widget-filters--offcanvas--mobile"
                     data-collapse
                     data-collapse-opened-class="filter--opened">
                    <h4 class="widget-filters__title widget__title"><?= Yii::t('app', 'Фільтр') ?></h4>

                    <form id="filter-form">
                        <div class="widget-filters__list">
                            <?php if (isset($category)): ?>
<!--                                --><?php //echo $this->render('filters-item-categories', ['category' => $category]) ?>
                            <?php endif; ?>

                            <?= $this->render('filters-item-price', [
                                'categoryMinPrice' => $categoryMinPrice,
                                'categoryMaxPrice' => $categoryMaxPrice,
                                'minPrice' => $minPrice,
                                'maxPrice' => $maxPrice,
                            ]) ?>

                            <?= $this->render('filters-item-brands', [
                                'filterBrandsItem' => $filterBrandsItem,
                                'category_products_all' => $category_products_all,
                                'products_all' => $products_all,
                            ]) ?>

<!--                            --><?php //echo $this->render('filters-item-properties', [
//                                'category' => $category,
//                                'propertiesFilter' => $propertiesFilter,
//                            ]) ?>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
$js = <<<JS
function applyProductFilters(isBrandChange = false) {
    let formData = [];
    
    let selectedBrand = $('input[name="filter_radio_brand"]:checked').val();
    if (selectedBrand !== undefined) {
        formData.push({ name: "filter_radio_brand", value: selectedBrand });
    }
    
    if (!isBrandChange) {
        let minPrice = $('#minPrice').val();
        let maxPrice = $('#maxPrice').val();
        if (minPrice) formData.push({ name: "minPrice", value: minPrice });
        if (maxPrice) formData.push({ name: "maxPrice", value: maxPrice });
    }
    
    formData.push({ name: "sort", value: $("#sort-form").val() });
    formData.push({ name: "count", value: $("#count-form").val() });

    $("#products-wrapper").css("opacity", "0.5");

    $.ajax({
        url: window.location.pathname,
        type: "GET",
        data: $.param(formData),
        dataType: "json",
        success: function (response) {
            if (response?.success && response?.html) {
                $("#products-wrapper").html(response.html);
            }
            
            if (response?.minPrice !== undefined && response?.maxPrice !== undefined) {
                let slider = document.querySelector('.filter-price__slider');
                
                if (slider && slider.noUiSlider) {
                    $('#minPrice').val(response.minPrice);
                    $('#maxPrice').val(response.maxPrice);
                    $('.filter-price__min-value').text(response.minPrice);
                    $('.filter-price__max-value').text(response.maxPrice);

                    // Обновляем границы и положение слайдера без вызова событий
                    slider.noUiSlider.updateOptions({
                        range: {
                            'min': Number(response.categoryMinPrice),
                            'max': Number(response.categoryMaxPrice)
                        }
                    }, false);
                    
                    slider.noUiSlider.set([Number(response.minPrice), Number(response.maxPrice)], false);
                }
            }
        },
        complete: function () {
            $("#products-wrapper").css("opacity", "1");
        }
    });
}

$(document).on("click", ".filter-list__item", function (e) {
    if (!$(e.target).is('input[type="radio"]')) {
        e.preventDefault();
        
        let input = $(this).find('input[type="radio"]');
        if (input.length) {
            $('input[name="filter_radio_brand"]').prop("checked", false);
            input.prop("checked", true);
            applyProductFilters(true); 
        }
    }
});

$(document).on("change", 'input[name="filter_radio_brand"]', function () {
    applyProductFilters(true); 
});

$(document).on("change", "#sort-form, #count-form", function() {
    applyProductFilters(false);
});

// Инициализация событий слайдера
var slider = document.querySelector('.filter-price__slider');

if (slider && slider.noUiSlider) {
    slider.noUiSlider.on('change', function (values, handle) {
        let minVal = Math.floor(values[0]);
        let maxVal = Math.ceil(values[1]);
        
        if (minVal <= 0 && maxVal <= 0) {
            return false;
        }

        $('#minPrice').val(minVal);
        $('#maxPrice').val(maxVal);
        
        applyProductFilters(false);
    });
}
JS;

$this->registerJs($js, View::POS_READY);
?>