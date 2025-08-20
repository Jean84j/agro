<?php

use backend\models\ProductsBackend;
use yii\helpers\Url;

?>
<div class="modal fade" id="addOrderItemModal" tabindex="-1"
     aria-labelledby="addOrderItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOrderItemModalLabel">Добавить товар в
                    заказ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addOrderItemForm" method="get"
                      action="<?= Url::to(['order/add-order-item']) ?>">
                    <input type="hidden" name="orderId" value="<?= $model->id ?>">

                    <div class="mb-3">
                        <label for="product-name" class="form-label">Товар</label>
                        <input type="text" class="form-control" id="product-name"
                               name="productName" list="product-list" autocomplete="off" required>
                        <datalist id="product-list">
                            <?php
                            $products = ProductsBackend::find()->all();
                            foreach ($products as $product) {
                                echo '<option value="' . $product->name . '" data-id="' . $product->id . '">';
                            }
                            ?>
                        </datalist>
                        <input type="hidden" name="productId" id="product-id">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Количество</label>
                        <input type="text" class="form-control" id="quantity"
                               name="quantity" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить в заказ
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("product-name").addEventListener("input", function () {
            let input = this.value;
            let options = document.querySelectorAll("#product-list option");
            let hiddenInput = document.getElementById("product-id");

            hiddenInput.value = ""; // Сбрасываем id

            options.forEach(option => {
                if (option.value === input) {
                    hiddenInput.value = option.getAttribute("data-id");
                }
            });
        });
    });
</script>