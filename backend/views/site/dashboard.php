<?php

use backend\widgets\ActiveUsersSite;
use backend\widgets\ActiveUsersSiteDay;
use backend\widgets\AverageOrder;
use backend\widgets\BrandOrders;
use backend\widgets\IncomeStatistics;
use backend\widgets\TotalOrders;
use backend\widgets\TotalSells;
use backend\widgets\UserDevice;
use yii\web\View;

$dataUrl = '/admin/uk/site/dashboard-tab-content';

?>
<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link active"
                        id="home-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#home-tab-content"
                        type="button"
                        role="tab"
                        aria-controls="home-tab-content"
                        aria-selected="true"
                >
                    <i class="fas fa-briefcase header-icon-tab"></i>
                    <span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                        data-url="<?= $dataUrl ?>"
                        class="nav-link nav-link-cli"
                        id="order-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#order-tab-content"
                        type="button"
                        role="tab"
                        aria-controls="order-tab-content"
                        aria-selected="true"
                >
                    <i class="fas fa-shopping-cart header-icon-tab"></i>
                    <span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                        data-url="<?= $dataUrl ?>"
                        class="nav-link"
                        id="views-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#views-tab-content"
                        type="button"
                        role="tab"
                        aria-controls="views-tab-content"
                        aria-selected="true"
                >
                    <i class="fas fa-eye header-icon-tab"></i>
                    <span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                        data-url="<?= $dataUrl ?>"
                        class="nav-link"
                        id="review-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#review-tab-content"
                        type="button"
                        role="tab"
                        aria-controls="review-tab-content"
                        aria-selected="true"
                >
                    <i class="fas fa-star-half-alt header-icon-tab"></i>
                    <span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link"
                        id="user-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#user-tab-content"
                        type="button"
                        role="tab"
                        aria-controls="user-tab-content"
                        aria-selected="true"
                >
                    <i class="fas fa-user-plus header-icon-tab"></i>
                    <span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link"
                        id="user-month-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#user-month-tab-content"
                        type="button"
                        role="tab"
                        aria-controls="user-month-tab-content"
                        aria-selected="true"
                >
                    <i class="fas fa-chart-line header-icon-tab"></i>
                    <span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                        data-url="<?= $dataUrl ?>"
                        class="nav-link"
                        id="top-review-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#top-review-tab-content"
                        type="button"
                        role="tab"
                        aria-controls="top-review-tab-content"
                        aria-selected="true"
                >
                    <i class="fas fa-trophy header-icon-tab"></i>
                    <i class="far fa-eye"></i>
                    <span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                        data-url="<?= $dataUrl ?>"
                        class="nav-link"
                        id="top-bay-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#top-bay-tab-content"
                        type="button"
                        role="tab"
                        aria-controls="top-bay-tab-content"
                        aria-selected="true"
                >
                    <i class="fas fa-trophy header-icon-tab"></i>
                    <i class="fas fa-money-bill-wave"></i>
                    <span class="nav-link-sa-indicator"></span>
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button
                        data-url="<?= $dataUrl ?>"
                        class="nav-link"
                        id="sub-top-review-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#sub-top-review-tab-content"
                        type="button"
                        role="tab"
                        aria-controls="sub-top-review-tab-content"
                        aria-selected="true"
                >
                    <i class="fas fa-eye-slash header-icon-tab"></i>
                    <span class="nav-link-sa-indicator"></span>
                </button>
            </li>

        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div
                    class="tab-pane fade show active"
                    id="home-tab-content"
                    role="tabpanel"
                    aria-labelledby="home-tab"
            >
                <div class="row g-4 g-xl-5">
                    <?php echo TotalSells::widget() ?>
                    <?php echo AverageOrder::widget() ?>
                    <?php echo TotalOrders::widget() ?>
                    <?php echo BrandOrders::widget() ?>
                    <?php echo IncomeStatistics::widget() ?>
                </div>
            </div>
            <div
                    class="tab-pane fade"
                    id="order-tab-content"
                    role="tabpanel"
                    aria-labelledby="order-tab"
            >
            </div>
            <div
                    class="tab-pane fade"
                    id="views-tab-content"
                    role="tabpanel"
                    aria-labelledby="views-tab"
            >
            </div>
            <div
                    class="tab-pane fade"
                    id="review-tab-content"
                    role="tabpanel"
                    aria-labelledby="review-tab"
            >
            </div>
            <div
                    class="tab-pane fade"
                    id="user-tab-content"
                    role="tabpanel"
                    aria-labelledby="user-tab"
            >
                <div class="row g-4 g-xl-5">
                    <?php echo UserDevice::widget() ?>
                    <?php echo ActiveUsersSite::widget() ?>
                </div>
            </div>
            <div
                    class="tab-pane fade"
                    id="user-month-tab-content"
                    role="tabpanel"
                    aria-labelledby="user-month-tab"
            >
                <div class="row g-4 g-xl-5">
                    <?php echo ActiveUsersSiteDay::widget() ?>
                </div>
            </div>
            <div
                    class="tab-pane fade"
                    id="top-review-tab-content"
                    role="tabpanel"
                    aria-labelledby="top-review-tab"
            >
            </div>
            <div
                    class="tab-pane fade"
                    id="top-bay-tab-content"
                    role="tabpanel"
                    aria-labelledby="top-bay-tab"
            >
            </div>

            <div
                    class="tab-pane fade"
                    id="sub-top-review-tab-content"
                    role="tabpanel"
                    aria-labelledby="sub-top-review-tab"
            >

        </div>
    </div>
</div>
    <style>
    .header-icon-tab {
        font-size: 30px;
        color: rgba(71, 153, 31, 0.84);
    }
    </style>

<?php
$script = <<< JS

$(document).ready(function () {
    $('#order-tab, #review-tab, #views-tab, #top-review-tab, #top-bay-tab, #sub-top-review-tab').on('click', function () {
        let id = $(this).attr('id');
        let target = $(this).data('bs-target');
        let url = $(this).data('url');

        if (!$(target).hasClass('loaded')) {
            $.ajax({
                url: url,
                type: 'POST',
                data: { id: id },
                success: function (response) {
                    if (response.success) {
                        $(target).html(response.content).addClass('loaded');
                         reinitializeTooltips();
                    } else {
                        console.error('Ошибка: неверный ответ от сервера');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Ошибка AJAX:', status, error);
                    console.error('Ответ сервера:', xhr.responseText);
                }
            });
        }
    });
    
     // **Функция для повторной инициализации tooltips**
    function reinitializeTooltips() {
        let tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(tooltipTriggerEl => {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // **Первоначальная инициализация tooltips при загрузке страницы**
    reinitializeTooltips();
    
});

JS;

$this->registerJs($script, View::POS_END);
?>


