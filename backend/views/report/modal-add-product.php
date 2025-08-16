<?php

use yii\helpers\Url;

?>

<div class="modal fade" id="addReportItemModal" tabindex="-1"
     aria-labelledby="addReportItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReportItemModalLabel">Додати
                    товар в
                    заказ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addReportItemForm" method="get"
                      action="<?= Url::to(['report/add-report-item']) ?>">
                    <input type="hidden" name="reportId"
                           value="<?= $id ?>">
                    <div class="mb-3">
                        <label for="product" class="form-label"><i
                                    class="fas fa-seedling"></i> Товар:</label>
                        <input aria-label="productName"
                               type="text" class="form-control" id="product-id"
                               name="productName" required>
                    </div>
                    <div class="mb-3">
                        <label for="package"
                               class="form-label"><i class="fas fa-box"></i>
                            Пакування:</label>
                        <select class="form-control" id="package" name="package"
                                required>
                            <option value="" disabled selected hidden>Виберіть
                                пакування...
                            </option>
                            <option style="font-weight: 500; font-size: 20px; background-color: #8fd19e" value="BIG">
                                Фермер
                            </option>
                            <option style="font-weight: 500; font-size: 20px;" value="SMALL">Дрібна</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity"
                               class="form-label"><i
                                    class="far fa-calendar-plus"></i> Кількість:</label>
                        <input type="text" class="form-control" id="quantity"
                               name="quantity" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><label for="price"
                                                  class="form-label"><i
                                        class="fas fa-money-bill-wave"></i>
                                Ціна:</label>
                            <input type="text" class="form-control" id="price"
                                   name="price" required>
                        </div>
                        <div class="col-4"><label for="in_price"
                                                  class="form-label"><i
                                        class="fas fa-hand-holding-usd"></i>
                                Вхід:</label>
                            <input type="text" class="form-control"
                                   id="in_price"
                                   name="in_price">
                        </div>
                        <div class="col-4"><label for="kurs"
                                                  class="form-label">
                                Курс:</label>
                            <input type="text" class="form-control"
                                   id="kurs"
                                   name="kurs"
                                   value="<?= $curs ?>"
                            >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><label for="discount_price"
                                                  class="form-label">
                                Знижка:</label>
                            <input type="text" class="form-control"
                                   id="discount_price"
                                   name="discount_price">
                        </div>
                        <div class="col-4"><label for="platform_price"
                                                  class="form-label">
                                Платформа:</label>
                            <input type="text" class="form-control"
                                   id="platform_price"
                                   name="platform_price">
                        </div>
                    </div>
                    <div class="mt-5 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Додати в
                            заказ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
