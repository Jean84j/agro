<?php

use yii\helpers\Html;

?>
<?php if (!$model->isNewRecord): ?>
    <div class="card mt-5">
        <div class="card-body p-5">
            <div class="mb-5">
                <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart">
                    <h2 class="mb-0 fs-exact-18"><?= Yii::t('app', 'Properties') ?></h2>
                </span>
            </div>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                    class="nav-link active"
                                    id="uk-properties-tab-2"
                                    data-bs-toggle="tab"
                                    data-bs-target="#uk-properties-tab-content-2"
                                    type="button"
                                    role="tab"
                                    aria-controls="uk-properties-tab-content-2"
                                    aria-selected="true"
                            >
                                UK<span class="nav-link-sa-indicator"></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                    class="nav-link"
                                    id="ru-properties-tab-2"
                                    data-bs-toggle="tab"
                                    data-bs-target="#ru-properties-tab-content-2"
                                    type="button"
                                    role="tab"
                                    aria-controls="ru-properties-tab-content-2"
                                    aria-selected="true"
                            >
                                RU<span class="nav-link-sa-indicator"></span>
                            </button>
                        </li>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div
                                class="tab-pane fade show active"
                                id="uk-properties-tab-content-2"
                                role="tabpanel"
                                aria-labelledby="uk-properties-tab-2"
                        >
                            <div id="properties-container">
                                <?php $index = 0;
                                foreach ($data as $productProperty): ?>
                                    <div class="row g-4">
                                        <div class="col-3">
                                            <?= $form->field($productProperty, "[$index]property_name")->textInput(['readonly' => true])->label(false) ?>
                                        </div>
                                        <div class="col-9">
                                            <?= $form->field($productProperty, "[$index]value")->textInput()->label(false) ?>
                                        </div>
                                    </div>
                                    <?= $form->field($productProperty, "[$index]property_id")->hiddenInput()->label(false) ?>
                                    <?= $form->field($productProperty, "[$index]id")->hiddenInput()->label(false) ?>
                                    <?php $index++; ?>
                                <?php endforeach; ?>
                                <div style="color: #898787 ">
                                    <span>' ' - не заповнене поле не показуеться на сайті</span><br>
                                    <span>'*' - поле в товарі не використовуеться</span>
                                </div>
                            </div>
                            <div class="col-auto d-flex mt-3">
                                <button type="button" id="translate-button" class="btn btn-outline-info">
                                    Перевести
                                </button>
                            </div>
                        </div>
                        <div
                                class="tab-pane fade"
                                id="ru-properties-tab-content-2"
                                role="tabpanel"
                                aria-labelledby="ru-properties-tab-2"
                        >
                            <div id="properties-container-ru">
                                <?php $index = 0;
                                foreach ($dataRu as $productProperty): ?>
                                    <div class="row g-4">
                                        <div class="col-3">
                                            <?= $form->field($productProperty, "[$index]property_name")->textInput(['readonly' => true, 'name' => "PropertiesTranslate[ru][$index][properties]"])->label(false) ?>
                                        </div>
                                        <div class="col-9">
                                            <?= $form->field($productProperty, "[$index]value")->textInput(['name' => "PropertiesTranslate[ru][$index][value]"])->label(false) ?>
                                        </div>
                                    </div>
                                    <?= $form->field($productProperty, "[$index]id")->hiddenInput([
                                        'name' => "PropertiesTranslate[ru][$index][id]"
                                    ])->label(false) ?>
                                    <?php $index++; ?>
                                <?php endforeach; ?>
                                <div style="color: #898787 ">
                                    <span>' ' - не заповнене поле не показуеться на сайті</span><br>
                                    <span>'*' - поле в товарі не використовуеться</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $js = <<<JS

$(document).ready(function () {
        function checkIfAllFieldsAreFilled() {
        let allFilled = true;

        $('#properties-container-ru .row').each(function () {
            let russianInput = $(this).find('input[name^="PropertiesTranslate[ru]"][name$="[value]"]');
            if (!russianInput.val()) {
                allFilled = false; // Если хотя бы одно поле пустое
                return false; // Прерываем цикл
            }
        });

        // Если все поля заполнены, деактивируем кнопку
        if (allFilled) {
            $('#translate-button').prop('disabled', true);
        } else {
            $('#translate-button').prop('disabled', false);
        }
    }

    // Проверка на загрузке страницы
    checkIfAllFieldsAreFilled();

    // Проверка при изменении значений в полях перевода
    $('#properties-container-ru .row input').on('input', function () {
        checkIfAllFieldsAreFilled();
    });
    
    $('#translate-button').click(function () {
        let productProperties = [];
        
        // Собираем все значения украинских полей 'value'
        $('#properties-container .row').each(function () {
            let propertyName = $(this).find('input[name$="[property_name]"]').val();
            let propertyValue = $(this).find('input[name$="[value]"]').val();
            
            if (propertyValue) {
                productProperties.push({ name: propertyName, value: propertyValue });
            }
        });

        if (productProperties.length > 0) {
            $.ajax({
                url: '/admin/uk/product/translate-properties',
                type: 'POST',
                data: {
                    properties: productProperties,
                },
                success: function (response) {
                    if (response.success) {
                        // Обновляем русские поля переведёнными значениями
                         $('#properties-container-ru .row').each(function (index) {
                            let russianValue = response.translations[index];
                            let russianInput = $(this).find('input[name^="PropertiesTranslate[ru]"][name$="[value]"]');
                            
                            // Проверяем, если поле пустое
                            if (!russianInput.val() && russianValue) {
                                russianInput.val(russianValue);
                            }
                        });
                         
                          checkIfAllFieldsAreFilled();
                         
                    } else {
                        console.log('Перевод не удался');
                    }
                },
                error: function () {
                    console.log('Ошибка перевода');
                }
            });
        } else {
            console.log('Нет свойств для перевода');
        }
    });
});

JS;
    $this->registerJs($js);
    ?>
<?php endif; ?>