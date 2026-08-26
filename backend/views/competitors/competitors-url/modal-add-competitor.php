<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;

Modal::begin([
    "id" => "addCompetitorsModal",
    "size" => Modal::SIZE_LARGE,
    'options' => [
        "data-bs-backdrop" => "static",
        "tabindex" => "-1",
    ],
    "title" => '+ Посилання ' . Html::encode($model->product->name),
    "footer" => "", // нужен для ajaxCrud, даже если не используешь
]);
?>

<input type="hidden" name="productId" id="productId" value="<?= $model->product->id ?>">

<div class="card">
    <div class="p-4">
        <div class="mb-3">
            <label for="link" class="form-label"><i class="fas fa-seedling"></i> Посилання</label>
            <input aria-label="link" type="text" class="form-control" id="linkAdd" name="link">
        </div>
    </div>
</div>


<div class="mt-5 d-flex justify-content-end">
    <button type="button" class="btn btn-primary" id="addCompetitorsBtn" disabled>Додати</button>
</div>

<?php Modal::end(); ?>

