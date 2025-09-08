<?php

use yii\helpers\Url;

?>
<div class="card">
    <div class="card-body p-5">
        <div class="mb-5 d-flex align-items-center justify-content-between">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart">
                                        <h2 class="mb-0 fs-exact-18">
                                            <?= Yii::t('app', 'FAQ') ?>
                                        </h2>
                                    </span>
            <div class="text-muted fs-exact-14"><a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#addFaqModal"><i
                            class="fas fa-plus"></i></a></div>

        </div>
        <?php echo $this->render('modal-add-faq', ['model' => $model]); ?>
        <div class="card-body card-background_color-faq">
            <div class="card">
                <div class="sa-divider"></div>
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th class="min-w-15x">Запитання</th>
                        <th class="min-w-15x">Відповідь</th>
                        <th class="min-w-15x">Показати</th>
                        <th class="w-min"></th>
                    </tr>
                    </thead>
                    <tbody id="faq-table">
                    <?php if (isset($faq)): ?>
                        <?php foreach ($faq as $question): ?>
                            <tr>
                                <td><?= $question['id'] ?></td>
                                <td><?= $question['question'] ?></td>
                                <td><?= $question['answer'] ?></td>
                                <td class="text-center align-middle">
                                    <label class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input is-valid checkbox-lg"
                                               id="<?= $question['id'] ?>"
                                               data-id="<?= $question['id'] ?>"
                                               data-product-id="<?= $model->id ?>"
                                            <?= $question['visible'] == 1 ? 'checked' : '' ?>
                                        />
                                    </label>
                                </td>
                                <td class="text-end">
                                    <div class="text-muted fs-exact-14">
                                        <a href="#" data-bs-toggle="modal"
                                           data-bs-target="#editFaqModal<?= $question['id'] ?>">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                    <!-- Удаление вопроса у товара -->
                                    <div class="text-muted fs-exact-14">
                                        <a href="<?= Url::to(['product/delete-product-faq']) ?>"
                                           data-id="<?= $question['id'] ?>"
                                           data-product-id="<?= $model->id ?>"
                                           class="text-danger delete-faq"
                                           onclick="return confirm('Вы уверены, что хотите удалить этот товар из заказа?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php echo $this->render('modal-edit-faq', ['model' => $model, 'faq' => $question]); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .checkbox-lg {
        transform: scale(1.2); /* Увеличение */
        margin: 5px; /* Чтобы не прилипал */
    }

    .card-background_color-faq {
        background-color: #2400ff17;
    }
</style>

<?php
$js = <<<JS

$(document).ready(function () {
    // Добавление FAQ
    $('#addFaqBtn').on('click', function () {
        const productId = $('#productId').val();
        const question = $('#question').val();
        const questionRu = $('#questionRu').val();
        const answer = $('#answer').val();
        const answerRu = $('#answerRu').val();

        if (!question || !questionRu || !answer || !answerRu) return;

        $.ajax({
            url: '/admin/uk/product/add-product-faq',
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-Token': yii.getCsrfToken(),
            },
            data: JSON.stringify({ productId, question, questionRu, answer, answerRu }),
            success: function (data) {
                if (data.success) {
                    $('.btn-close').click();
                    $('#question, #questionRu, #answer, #answerRu').val('');
                   document.getElementById('faq-table').innerHTML = data.faq;
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
    $(document).on('click', '.editFaqBtn', function () {
        const faqId = $(this).data('id');
        
        // Получаем значения из соответствующих полей
        const id         = $('#idEdit' + faqId).val();
        const productId  = $('#productIdEdit' + faqId).val();
        const question   = $('#questionEdit' + faqId).val();
        const questionRu = $('#questionRuEdit' + faqId).val();
        const answer     = $('#answerEdit' + faqId).val();
        const answerRu   = $('#answerRuEdit' + faqId).val();
        
        // Проверка, что все поля заполнены
        if (!question || !questionRu || !answer || !answerRu) {
            alert('Будь ласка, заповніть усі поля.');
            return;
        }

        // Отправляем данные на сервер
        $.ajax({
            url: '/admin/uk/product/edit-product-faq',
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-Token': yii.getCsrfToken(),
            },
            data: JSON.stringify({
                id: id,
                productId: productId,
                question: question,
                questionRu: questionRu,
                answer: answer,
                answerRu: answerRu
            }),
            success: function (data) {
                if (data.success) {
                    // Закрываем модалку только для этого FAQ
                    $('#editFaqModal' + faqId + ' .btn-close').click();
                    
                    document.getElementById('faq-table').innerHTML = data.faq;
                    
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


$(document).on('click', '.delete-faq', function(e) {
    e.preventDefault();
    
    const btn = $(this);
    const faqId = btn.data('id');
    const productId = btn.data('productId');
    const url = btn.attr('href');
 
    $.ajax({
        url: url,
        type: 'POST',
        data: { 
            id: faqId,
            productId: productId
        },
        success: function(response) {
            if (response.success) {
                document.getElementById('faq-table').innerHTML = response.faq;
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


$(document).on('change', '.form-check-input.is-valid', function () {
    const check = $(this);
    const checkboxId = check.data('id');
    const productId = check.data('product-id');
    const newState = check.prop('checked') ? 1 : 0;

    console.log('ID:', checkboxId, 'Product:', productId, 'New State:', newState);

    $.ajax({
        url: '/admin/uk/product/update-checkbox-faq',
        type: 'POST',
        data: {
            id: checkboxId,
            state: newState,
            productId: productId
        },
        success: function (response) {
            if (response.success) {
                
            } else {
                alert(response.error || 'Ошибка при сохранении');
                check.prop('checked', !newState); // Вернуть обратно
            }
        },
        error: function () {
            alert('Ошибка соединения');
            check.prop('checked', !newState); // Вернуть обратно
        }
    });
});


JS;

$this->registerJs($js);
?>

