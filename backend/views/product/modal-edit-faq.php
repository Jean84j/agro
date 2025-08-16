<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;

Modal::begin([
    "id" => "editFaqModal{$faq['id']}",
    "size" => Modal::SIZE_LARGE,
    'options' => [
        "data-bs-backdrop" => "static",
        "tabindex" => "-1", // важно для совместимости
        "aria-labelledby" => "editFaqModalLabel{$faq['id']}",
    ],
    "title" => "Редагувати запитання для " . Html::encode($model->name),
    "closeButton" => [
        "class" => "btn-close btn-close-edit",
        "aria-label" => "Close",
        "data-bs-dismiss" => "modal",
    ],
    "footer" => "", // если нужно, можно добавить кнопки
]);
?>

<input type="hidden" name="productId" id="productIdEdit<?= $faq['id'] ?>" value="<?= $model->id ?>">
<input type="hidden" name="id" id="idEdit<?= $faq['id'] ?>" value="<?= $faq['id'] ?>">

<div class="card">
    <div class="p-4">
        <div class="mb-3">
            <label for="questionEdit<?= $faq['id'] ?>" class="form-label"><i class="fas fa-seedling"></i> Запитання:</label>
            <input type="text" class="form-control" id="questionEdit<?= $faq['id'] ?>"
                   name="question" value="<?= Html::encode($faq['question']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="answerEdit<?= $faq['id'] ?>" class="form-label"><i class="fas fa-seedling"></i> Відповідь:</label>
            <textarea class="form-control" id="answerEdit<?= $faq['id'] ?>" name="answer" rows="4" required><?= Html::encode($faq['answer']) ?></textarea>
        </div>
    </div>
</div>

<div class="card mt-5">
    <div class="p-4">
        <div class="mb-3">
            <label for="questionRuEdit<?= $faq['id'] ?>" class="form-label"><i class="fas fa-seedling"></i> Запитання (RU):</label>
            <input type="text" class="form-control" id="questionRuEdit<?= $faq['id'] ?>"
                   name="questionRu" value="<?= Html::encode($faq['questionRu']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="answerRuEdit<?= $faq['id'] ?>" class="form-label"><i class="fas fa-seedling"></i> Відповідь (RU):</label>
            <textarea class="form-control" id="answerRuEdit<?= $faq['id'] ?>" name="answerRu" rows="4" required><?= Html::encode($faq['answerRu']) ?></textarea>
        </div>
    </div>
</div>

<div class="mt-5 d-flex justify-content-end" id="faq-container">
    <button type="button" class="btn btn-primary editFaqBtn" data-id="<?= $faq['id'] ?>">Додати</button>
</div>

<?php Modal::end(); ?>
