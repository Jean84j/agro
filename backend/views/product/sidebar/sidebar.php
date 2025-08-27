<?php

use yii\web\View;

/** @var yii\web\View $this */
/** @var common\models\shop\Product $model */
/** @var yii\widgets\ActiveForm $form */

$tabs = $model->getSidebarTabs();
?>
<div class="sa-entity-layout__sidebar">
    <ul class="nav nav-tabs" role="tablist">
        <?php foreach ($tabs as $tab): ?>
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link <?= !empty($tab['active']) ? 'active' : '' ?>"
                        id="<?= $tab['id'] ?>-tab-1"
                        data-bs-toggle="tab"
                        data-bs-target="#<?= $tab['id'] ?>-tab-content-1"
                        type="button"
                        role="tab"
                        aria-controls="<?= $tab['id'] ?>-tab-content-1"
                        aria-selected="<?= !empty($tab['active']) ? 'true' : 'false' ?>"
                >
                    <?= $tab['label'] ?><span class="nav-link-sa-indicator"></span>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content mt-4">
        <?php foreach ($tabs as $tab): ?>
            <div
                    class="tab-pane fade <?= !empty($tab['active']) ? 'show active' : '' ?>"
                    id="<?= $tab['id'] ?>-tab-content-1"
                    role="tabpanel"
                    aria-labelledby="<?= $tab['id'] ?>-tab-1"
            >
                <?= $this->render($tab['view'], [
                    'model' => $model,
                    'form' => $form,
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->render('@backend/views/product/sidebar/modal-image-view') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const submitButton = document.getElementById('submitVariantBtn');
        submitButton.addEventListener('click', function () {
            // Собираем данные из модального окна
            const productId = document.querySelector('input[name="productId"]').value;
            const variantId = document.getElementById('variantId').value;
            const volume = document.getElementById('volume').value;
            const productVolume = document.getElementById('productVolume').value;

            if (!variantId || !volume || !productVolume) {
                return; // Останавливаем выполнение, если поля не заполнены
            }
            // Отправляем данные на сервер
            fetch('/admin/uk/product/add-product-variants', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': yii.getCsrfToken(), // Убедись, что CSRF токен подключён
                },
                body: JSON.stringify({
                    productId: productId,
                    variantId: variantId,
                    productVolume: productVolume,
                    volume: volume,
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
                        document.getElementById('variantId').value = '';
                        document.getElementById('volume').value = '';

                        document.getElementById('variant-table').innerHTML = data.variants;

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

<?php
$script = <<< JS

 $(document).on('click', '.image-link', function () {
    const imageUrl = $(this).data('image-url');
    $('#modalImage').attr('src', imageUrl);
});

JS;

$this->registerJs($script, View::POS_END);
?>
