<?php

use common\models\shop\Category;
use common\models\shop\PropertiesName;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
    <div class="sa-entity-layout__sidebar">
        <div class="card w-100 mt-5">
            <div class="card-body p-5">
                <?= $this->render('/_partials/card-name-label', ['cardName' => 'visibility']); ?>
                <div class="mb-4">
                    <?php Pjax::begin(['id' => 'visibility-pjax']); ?>
                    <?= $form->field($model, 'visibility')
                        ->radioList(
                            [
                                1 => Yii::t('app', 'Published'),
                                0 => Yii::t('app', 'Hidden'),
                            ],
                            [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $return = '<label class="form-check">';
                                    $return .= '<input class="form-check-input" id="visibility" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>';
                                    $return .= ucwords($label);
                                    $return .= '</label>';
                                    return $return;
                                },
                            ],
                        )->label(false); ?>
                    <?= Html::hiddenInput('category_id', $model->id, ['id' => 'category-id']) ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
        <div class="card w-100 mt-5">
            <div class="card-body p-5">
                <?= $this->render('/_partials/card-name-label', ['cardName' => 'Parent category']); ?>
                <?php
                $data = ArrayHelper::map(Category::find()
                    ->where(['parentId' => null])->orderBy('id')
                    ->asArray()->all(), 'id', 'name');
                echo $form->field($model, 'parentId')->widget(Select2::class, [
                    'data' => $data,
                    'theme' => Select2::THEME_DEFAULT,
                    'maintainOrder' => true,
                    'pluginLoading' => false,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select category...'),
                        'class' => 'sa-select2 form-select',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '272px',
                    ],
                ])->label(false);
                ?>
                <div class="form-text"><?= Yii::t('app', 'Select a category that will be the parent of the current one.') ?></div>
            </div>
        </div>

        <?= $this->render('/_partials/image-upload', $params) ?>

        <div class="card w-100 mt-5">
            <div class="card-body p-5">
                <?= $this->render('/_partials/card-name-label', ['cardName' => 'SVG for menu']); ?>
                <div class="mb-4">
                    <?= $form->field($model, 'svg')->textInput(['maxlength' => true])->label(Yii::t('app', 'SVG')) ?>
                </div>
            </div>
        </div>
        <div class="card w-100 mt-5">
            <div class="card-body p-5">
                <?= $this->render('/_partials/card-name-label', ['cardName' => 'Properties']); ?>
                <div class="mb-4">
                    <?php
                    $data = ArrayHelper::map(PropertiesName::find()->orderBy('id')->asArray()->all(), 'id', 'name');
                    echo $form->field($model, 'properties')->widget(Select2::class, [
                        'data' => $data,
                        'theme' => Select2::THEME_DEFAULT,
                        'maintainOrder' => true,
                        'pluginLoading' => false,
                        'toggleAllSettings' => [
                            'selectLabel' => '<i class="fas fa-check-circle"></i> Выбрать все',
                            'unselectLabel' => '<i class="fas fa-times-circle"></i> Удалить все',
                            'selectOptions' => ['class' => 'text-success'],
                            'unselectOptions' => ['class' => 'text-danger'],
                        ],
                        'options' => [
                            'placeholder' => 'Виберіть продукт ...',
                            'class' => 'sa-select2 form-select',
                            // 'data-tags'=>'true',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'closeOnSelect' => false,
//                        'tags' => true,
                            'tokenSeparators' => [', ', ' '],
                            'maximumInputLength' => 5,
                            'width' => '100%',
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        #flash-message {
            font-size: x-large;
            position: fixed; /* Фиксируем элемент */
            top: 20px; /* Отступ сверху */
            right: 20px; /* Отступ справа */
            z-index: 9999; /* Убедимся, что сообщение всегда будет сверху */
            display: none; /* Скрываем сообщение по умолчанию */
            padding: 10px 20px; /* Немного отступов внутри */
            border-radius: 5px; /* Скругление углов */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Тень для лучшего вида */
        }
    </style>
<?php
$js = <<<JS

$(document).on('change', '#visibility', function() {
    let value = $(this).val();
    let id = $('#category-id').val();

    $.ajax({
        url: '/admin/uk/category/update-visibility',
        type: 'POST',
        data: {
             id: id,
            value: value
            // _csrf: yii.getCsrfToken()
        },
        success: function(data) {
            
            if (data.message) {
                showMessage(data.message, data.background);  // Выводим сообщение на экран
            }
            // Если нужно обновить Pjax блок
            // $.pjax.reload({container: '#visibility-pjax', async: false});
        },
        error: function() {
            alert('Ошибка при сохранении');
        }
    });
});

// Функция для отображения сообщения
function showMessage(message, background) {
    // Создаем элемент с сообщением
    let messageHtml = '<div id="flash-message" class="alert text-white ' + background + '">' + message + '</div>';

    // Вставляем сообщение в body
    $('body').append(messageHtml);

    // Показываем сообщение
    $('#flash-message').fadeIn();

    // Через 2 секунды скрываем сообщение
    setTimeout(function() {
        $('#flash-message').fadeOut(function() {
            $(this).remove();  // Удаляем сообщение из DOM
        });
    }, 2000);
}

JS;
$this->registerJs($js);
?>