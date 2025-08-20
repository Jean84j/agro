<?php

use backend\models\ProductsBackend;
use common\models\shop\ProductPackaging;

$firstWord = explode(' ', $model->name)[0];

$productVolume = ProductPackaging::find()
    ->select('volume')
    ->where(['product_variant_id' => $model->id])
    ->scalar();


$productVariant = ProductPackaging::find()
    ->select('product_variant_id')
    ->where(['product_id' => $model->id])
    ->asArray()
    ->column();

$productsVariantCategory = ProductsBackend::find()
    ->select(['id', 'name'])
    ->where(['category_id' => $model->category_id])
    ->andWhere(['<>', 'id', $model->id])
    ->andWhere(['not in', 'id', $productVariant])
    ->andWhere(['like', 'name', $firstWord . '%', false])
    ->all();
?>
<div class="modal fade" id="addVariantModal" tabindex="-1"
     aria-labelledby="addVariantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVariantModalLabel">+
                    варіант фасовки <?= $model->name ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="productId"
                       value="<?= $model->id ?>">

                <div class="row mb-3">
                    <div class="col-9">
                        <input type="text" class="form-control"
                               value="<?= $model->name ?>"
                               readonly>
                    </div>
                    <div class="col-3">
                        <?php if ($productVolume): ?>
                        <input aria-label="volume"
                               id="productVolume"
                               name="productVolume"
                               type="text" class="form-control"
                               value="<?= $productVolume ?>"
                               readonly>
                        <?php else: ?>
                            <input aria-label="volume"
                                   id="productVolume"
                                   name="productVolume"
                                   type="text" class="form-control"
                                   value="<?= $productVolume ?>">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="variantId"
                           class="form-label"><i class="fas fa-box"></i>
                        Варіант:</label>
                    <select class="form-control" id="variantId" name="variantId">
                        <option value="" disabled selected hidden>Виберіть
                            варіант...
                        </option>
                        <?php foreach ($productsVariantCategory as $item): ?>
                            <option value="<?= $item->id ?>">
                                <?= $item->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="volume_id" class="form-label"><i
                                class="fas fa-seedling"></i> Фасовка:</label>
                    <input aria-label="volume"
                           type="text" class="form-control" id="volume"
                           name="volume">
                </div>
                <div class="mt-5 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="submitVariantBtn">Додати
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
