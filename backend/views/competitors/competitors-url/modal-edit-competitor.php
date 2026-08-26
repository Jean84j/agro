<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;

Modal::begin([
    "id" => "editCompetitorModal{$competitor['id']}",
    "size" => Modal::SIZE_LARGE,
    'options' => [
        "data-bs-backdrop" => "static",
        "tabindex" => "-1", // важно для совместимости
        "aria-labelledby" => "editFaqModalLabel{$competitor['id']}",
    ],
    "title" => "Редагувати посилання для " . Html::encode($model->product->name),
    "closeButton" => [
        "class" => "btn-close btn-close-edit",
        "aria-label" => "Close",
        "data-bs-dismiss" => "modal",
    ],
    "footer" => "", // если нужно, можно добавить кнопки
]);
?>

<input type="hidden" name="productId" id="productIdEdit<?= $competitor['id'] ?>" value="<?= $model->product->id ?>">
<input type="hidden" name="id" id="idEdit<?= $competitor['id'] ?>" value="<?= $competitor['id'] ?>">

<div class="card">
    <div class="p-4">
        <div class="mb-3">
            <label for="nameEdit<?= $competitor['id'] ?>" class="form-label"><i class="fas fa-seedling"></i> Сайт</label>
            <input type="text" class="form-control" id="nameEdit<?= $competitor['id'] ?>"
                   name="name" value="<?= Html::encode($competitor['name']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="questionEdit<?= $competitor['id'] ?>" class="form-label"><i class="fas fa-seedling"></i> Посилання</label>
            <input type="text" class="form-control" id="competitorEdit<?= $competitor['id'] ?>"
                   name="link" value="<?= Html::encode($competitor['url']) ?>" required>
        </div>
    </div>
</div>


<div class="mt-5 d-flex justify-content-end" id="competitor-container">
    <button type="button" class="btn btn-primary editCompetitorBtn" data-id="<?= $competitor['id'] ?>">Сохранить</button>
</div>

<?php Modal::end(); ?>
