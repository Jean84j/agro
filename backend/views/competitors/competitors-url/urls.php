<?php use yii\helpers\Url; ?>

    <div class="card">
        <div class="card-body p-5">
            <div class="mb-5 d-flex align-items-center justify-content-between">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart">
                                        <h2 class="mb-0 fs-exact-18">
                                            <?= Yii::t('app', 'Competitors') ?>
                                        </h2>
                                    </span>
                <div class="text-muted fs-exact-14">
                    <a href="#" data-bs-toggle="modal"
                       data-bs-target="#addCompetitorsModal">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>

            </div>

            <?php echo $this->render('modal-add-competitor', ['model' => $model]); ?>

            <div class="card-body card-background_color">
                <div class="card">
                    <div class="sa-divider"></div>
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th class="min-w-15x">Посилання</th>
                            <th class="min-w-15x">Ціна</th>
                            <th class="min-w-10x">Оновлено</th>
                            <th class="w-min"></th>
                        </tr>
                        </thead>

                        <?php echo $this->render('_competitors-table', [
                            'model' => $model,
                            'competitors' => $competitors,
                        ]); ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card-background_color {
            background-color: rgba(255, 225, 0, 0.61);
        }
    </style>

<?php

$url = Url::to(['competitors/check-name']);

$js = <<<JS

$(document).ready(function () {
    $('#addCompetitorsBtn').on('click', function () {
        const productId = $('#productId').val();
        const link = $('#linkAdd').val();
        
        if (!link) return;

        $.ajax({
            url: '/admin/uk/competitors/add-competitors',
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-Token': yii.getCsrfToken(),
            },
            data: JSON.stringify({ productId, link }),
            
            success: function (data) {
                if (data.success) {
                    $('.btn-close').click();
                    $('#linkAdd').val('');
                   document.getElementById('competitors-table').innerHTML = data.competitors;
                } else {
                    alert('Помилка: ' + data.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Помилка:', error);
                alert('Сталася помилка при відправці даних.');
            }
        });
    });
    
    
    // Клик по кнопке редактирования FAQ
    $(document).on('click', '.editCompetitorBtn', function () {
        const competitorId = $(this).data('id');
        
        // Получаем значения из соответствующих полей
        const id         = $('#idEdit' + competitorId).val();
        const productId  = $('#productIdEdit' + competitorId).val();
        const link   = $('#competitorEdit' + competitorId).val();
        
        // Проверка, что все поля заполнены
        if (!link) {
            alert('Будь ласка, заповніть усі поля.');
            return;
        }

        // Отправляем данные на сервер
        $.ajax({
            url: '/admin/uk/competitors/edit-competitors',
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-Token': yii.getCsrfToken(),
            },
            data: JSON.stringify({
                id: id,
                productId: productId,
                link: link
              
            }),
            success: function (data) {
                if (data.success) {
                  
                    $('#editCompetitorModal' + competitorId + ' .btn-close').click();
                    
                    document.getElementById('competitors-table').innerHTML = data.competitors;
                    
                } else {
                    alert('Помилка: ' + data.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Помилка:', error);
                alert('Сталася помилка при відправці даних.');
            }
        });
    });

});


$(document).on('click', '.delete-competitor', function(e) {
    e.preventDefault();
    
    const btn = $(this);
    const competitorId = btn.data('id');
    const productId = btn.data('productId');
    const url = btn.attr('href');
 
    $.ajax({
        url: url,
        type: 'POST',
        data: { 
            id: competitorId,
            productId: productId
        },
        success: function(response) {
            if (response.success) {
                document.getElementById('competitors-table').innerHTML = response.competitors;
            } else {
                alert(response.error || 'Ошибка при удалении.');
            }
        },
        error: function() {
            alert('Произошла ошибка при удалении.');
        }
    });

    return false;
});


$('#linkAdd').on('input change', function() {
    var link = $(this).val();
    if (link.length > 0) {
        $.ajax({
            url: '$url',
            data: {link: link},
            success: function(data) {
                if (data.exists) {
                    $('#linkAdd').css('background-color', '#e9544e5c');
                    $('#addCompetitorsBtn').prop('disabled', true);
                } else {
                    $('#linkAdd').css('background-color', '#4ee95e5c');
                    $('#addCompetitorsBtn').prop('disabled', false);
                }
            }
        });
    } else {
        $('#linkAdd').css('background-color', '');
    }
});

JS;

$this->registerJs($js);
?>