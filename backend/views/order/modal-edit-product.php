<?php

use yii\helpers\Url;

?>
<div class="modal fade" id="editOrderItemModal<?= $orderItem->id ?>"
     tabindex="-1"
     aria-labelledby="editOrderItemModalLabel<?= $orderItem->id ?>"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="editOrderItemModalLabel<?= $orderItem->id ?>">
                    Редактировать товар</h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="get"
                      action="<?= Url::to(['order/update-order-item']) ?>">
                    <input type="hidden" name="orderItemId"
                           value="<?= $orderItem->id ?>">
                    <div class="mb-3">
                        <label for="price<?= $orderItem->id ?>"
                               class="form-label">Цена:</label>
                        <input type="text" class="form-control"
                               id="price<?= $orderItem->id ?>" name="price"
                               value="<?= $orderItem->price ?>">
                    </div>
                    <div class="mb-3">
                        <label for="quantity<?= $orderItem->id ?>"
                               class="form-label">Количество:</label>
                        <input type="text" class="form-control"
                               id="quantity<?= $orderItem->id ?>"
                               name="quantity"
                               value="<?= $orderItem->quantity ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить
                        изменения
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
