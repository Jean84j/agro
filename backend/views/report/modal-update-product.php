<?php

use yii\helpers\Url;

?>
<div class="modal fade"
     id="editReportItemModal<?= $reportItem->id ?>"
     tabindex="-1"
     aria-labelledby="editReportItemModalLabel<?= $reportItem->id ?>"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="editReportItemModalLabel<?= $reportItem->id ?>">
                    Редагувати товар</h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <!-- Форма для редактирования данных заказа -->
            <div class="modal-body">
                <form method="get"
                      action="<?= Url::to(['report/update-report-item']) ?>">
                    <input type="hidden" name="reportItemId"
                           value="<?= $reportItem->id ?>">
                    <div class="mb-3">
                        <label for="quantity<?= $reportItem->id ?>"
                               class="form-label">
                            Кількість:</label>
                        <input type="text" class="form-control"
                               id="quantity<?= $reportItem->id ?>"
                               name="quantity"
                               value="<?= $reportItem->quantity ?>">
                    </div>
                    <div class="mb-3">
                        <label for="package<?= $reportItem->id ?>"
                               class="form-label">
                            Пакування:</label>
                        <select class="form-control"
                                id="package<?= $reportItem->id ?>"
                                name="package">
                            <?php
                            $selectedItem = $reportItem->package == 'BIG' ? 'Фермер' : 'Дрібна';
                            ?>
                            <option value="<?= $reportItem->package ?>"
                                    selected><?= $selectedItem ?></option>
                            <option value="BIG" <?= $reportItem->package == 'BIG' ? 'disabled' : '' ?>>
                                Фермер
                            </option>
                            <option value="SMALL" <?= $reportItem->package == 'SMALL' ? 'disabled' : '' ?>>
                                Дрібна
                            </option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="price<?= $reportItem->id ?>"
                                   class="form-label">
                                Ціна:</label>
                            <input type="text"
                                   class="form-control"
                                   id="price<?= $reportItem->id ?>"
                                   name="price"
                                   value="<?= $reportItem->price ?>">
                        </div>
                        <div class="col-4">
                            <label for="in_price<?= $reportItem->id ?>"
                                   class="form-label">
                                Вхід:</label>
                            <input type="text"
                                   class="form-control"
                                   id="in_price<?= $reportItem->id ?>"
                                   name="in_price"
                                   value="<?= $reportItem->entry_price ?>">
                        </div>
                        <div class="col-4"><label
                                for="kurs<?= $reportItem->id ?>"
                                class="form-label">
                                Курс:</label>
                            <input type="text"
                                   class="form-control"
                                   id="kurs<?= $reportItem->id ?>"
                                   name="kurs"
                                   value="<?= $reportItem->kurs ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><label
                                for="discount_price<?= $reportItem->id ?>"
                                class="form-label">
                                Знижка:</label>
                            <input type="text"
                                   class="form-control"
                                   id="discount_price<?= $reportItem->id ?>"
                                   name="discount_price"
                                   value="<?= $reportItem->discount ?>">
                        </div>
                        <div class="col-4"><label
                                for="platform_price<?= $reportItem->id ?>"
                                class="form-label">
                                Платформа:</label>
                            <input type="text"
                                   class="form-control"
                                   id="platform_price<?= $reportItem->id ?>"
                                   name="platform_price"
                                   value="<?= $reportItem->platform_price ?>">
                        </div>
                    </div>
                    <div class="mt-5 d-flex justify-content-end">
                        <button type="submit"
                                class="btn btn-primary">
                            Сохранить
                            изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
