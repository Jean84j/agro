<?php ?>
<div class="card w-100 mt-5">
    <div class="card-body p-5">
        <div class="mb-3">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Words') ?></h2></span>
            <a href="#" data-bs-toggle="modal"
               data-bs-target="#addWordsModal">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
    <div class="mt-n5">
        <div class="sa-divider"></div>
        <div class="table-responsive">
            <table class="sa-table">
                <thead>
                <tr>
                    <th class="min-w-5x">UK</th>
                    <th class="w-min"></th>
                </tr>
                </thead>
                <?= $this->render('modal-add-words', ['model' => $model]) ?>
                <tbody id="words-table">
                <?php if (!empty($words)) : ?>
                    <?php $productId = $model->id;
                    $i = 0; ?>
                    <?php foreach ($words as $word) : ?>
                        <tr>
                            <td>
                                <input type="text" name="word[<?= $word['id'] ?>]"
                                       class="form-control form-control-sm"
                                       value="<?= $word['uk_word'] ?>" readonly/>
                            </td>
                            <td>
                                <a href="#"
                                   id="<?= $word['id'] ?>"
                                   class="text-danger del-word"
                                   onclick="removeWordStock(<?= $word['id'] ?>, '<?= $_SESSION['_language'] ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                         height="12" viewBox="0 0 12 12" fill="currentColor">
                                        <path d="M10.8,10.8L10.8,10.8c-0.4,0.4-1,0.4-1.4,0L6,7.4l-3.4,3.4c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L4.6,6L1.2,2.6 c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L6,4.6l3.4-3.4c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L7.4,6l3.4,3.4 C11.2,9.8,11.2,10.4,10.8,10.8z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <?php $i++; endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="sa-divider"></div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const submitButton = document.getElementById('submitWordsBtn');
        submitButton.addEventListener('click', function () {
            // Собираем данные из модального окна
            const productId = document.querySelector('input[name="productId"]').value;
            const categoryId = document.querySelector('input[name="categoryId"]').value;
            const wordUk = document.querySelector('input[name="wordUk"]').value;
            const wordRu = document.querySelector('input[name="wordRu"]').value;

            if (!wordUk || !wordRu) {
                return; // Останавливаем выполнение, если поля не заполнены
            }
            // Отправляем данные на сервер
            fetch('/admin/uk/product/add-words', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': yii.getCsrfToken(), // Убедись, что CSRF токен подключён
                },
                body: JSON.stringify({
                    productId: productId,
                    categoryId: categoryId,
                    wordUk: wordUk,
                    wordRu: wordRu,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const closeButton = document.querySelector('.btn-close');
                        // Проверяем, что кнопка существует
                        if (closeButton) {
                            // Симулируем клик по кнопке
                            closeButton.click();
                        }
                        // Очищаем поля формы
                        document.getElementById('wordUk').value = '';
                        document.getElementById('wordRu').value = '';

                        document.getElementById('words-table').innerHTML = data.words;

                    } else {
                        alert('Помилка: ' + data.error);
                    }
                })
                .catch((error) => {
                    console.error('Помилка:', error);
                    alert('Сталася помилка при відправці даних.');
                });
        });
    });
</script>