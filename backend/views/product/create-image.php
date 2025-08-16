<?php

use kartik\file\FileInput;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $imageModel \common\models\shop\ProductImage */
/* @var $form yii\widgets\ActiveForm */

$id = Yii::$app->request->get('id');

?>
<div class="container">
    <div class="upload-image-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($imageModel, 'product_id')->hiddenInput()->label(false) ?>

        <?= $form->field($imageModel, 'name[]')->widget(FileInput::class, [
            'language' => 'uk',
            'options' => [
                'multiple' => true,
            ],
            'pluginEvents' => [
                "fileuploaded" => "function(event, data, previewId, index) { 
                    $('#images-table').load(window.location.href + ' #images-table > *');
                }",
                "fileuploaderror" => "function(event, previewId, index, fileId) {
                    console.log('File Upload Error', 'ID: ' + fileId + ', Thumb ID: ' + previewId);
                }",
                "filechunksuccess" => "function(event, fileId, index, retry, fm, rm, outData) {
                    alert('File Chunk Success', 'ID: ' + fileId + ', Index: ' + index + ', Retry: ' + retry);
                }",
            ],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['ajax-upload', 'id' => $id]),
                'allowedFileExtensions' => ['jpg', 'gif', 'png', 'jpeg'],
                'previewFileType' => 'any',
                'maxFileCount' => 5,
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => true,
                // Кастомизация кнопок
                'browseClass' => 'btn btn-primary',
                'uploadClass' => 'btn btn-success',
                'removeClass' => 'btn btn-danger',
            ],
        ]); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
