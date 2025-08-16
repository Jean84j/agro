<?php

use kartik\file\FileInput;
use yii\widgets\ActiveForm;

?>

<div class="container">
    <div class="upload-image-form">
        <br>
        <br>
        <br>
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'], // Обязательно укажите эту опцию для загрузки файлов
        ]); ?>

        <?php echo $form->field($model, 'excelFile')->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'], // Определите типы файлов, которые можно загружать
        ]); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<br>
<br>
<br>
