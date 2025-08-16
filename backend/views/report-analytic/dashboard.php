<?php

use backend\widgets\ReportAverageCost;
use backend\widgets\ReportCountOrders;
use backend\widgets\ReportIncome;
use backend\widgets\ReportPlatform;
use backend\widgets\ReportSumPayment;
use yii\web\View;

$dataUrl = '/admin/uk/report-analytic/dashboard-tab-content';

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
                    Home<span class="nav-link-sa-indicator"></span>
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
                    Test<span class="nav-link-sa-indicator"></span>
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
                    <?php echo ReportSumPayment::widget() ?>
                    <?php echo ReportAverageCost::widget() ?>
                    <?php echo ReportCountOrders::widget() ?>
                    <?php echo ReportPlatform::widget() ?>
                    <?php echo ReportIncome::widget() ?>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="order-tab-content"
                role="tabpanel"
                aria-labelledby="order-tab"
            >
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS

$(document).ready(function () {
    $('#order-tab').on('click', function () {
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


