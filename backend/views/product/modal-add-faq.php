<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;

Modal::begin([
    "id" => "addFaqModal",
    "size" => Modal::SIZE_LARGE,
    'options' => [
        "data-bs-backdrop" => "static",
        "tabindex" => "-1",
    ],
    "title" => '+ запитання для ' . Html::encode($model->name),
    "footer" => "", // нужен для ajaxCrud, даже если не используешь
]);
?>

<input type="hidden" name="productId" id="productId" value="<?= $model->id ?>">

<div class="card">
    <div class="p-4">
        <div class="mb-3">
            <label for="question" class="form-label"><i class="fas fa-seedling"></i> Запитання:</label>
            <input aria-label="question" type="text" class="form-control" id="question" name="question">
        </div>
        <div class="mb-3">
            <label for="answer" class="form-label"><i class="fas fa-seedling"></i> Відповідь:</label>
            <textarea class="form-control" id="answer" name="answer" aria-label="answer" rows="4"></textarea>
        </div>
    </div>
</div>

<div class="card mt-5">
    <div class="p-4">
        <div class="mb-3">
            <label for="questionRu" class="form-label"><i class="fas fa-seedling"></i> Запитання (RU):</label>
            <input aria-label="questionRu" type="text" class="form-control" id="questionRu" name="questionRu">
        </div>
        <div class="mb-3">
            <label for="answerRu" class="form-label"><i class="fas fa-seedling"></i> Відповідь (RU):</label>
            <textarea class="form-control" id="answerRu" name="answerRu" aria-label="answerRu" rows="4"></textarea>
        </div>
    </div>
</div>

<div class="mt-5 d-flex justify-content-end">
    <button type="button" class="btn btn-primary" id="addFaqBtn">Додати</button>
</div>

<?php Modal::end(); ?>
