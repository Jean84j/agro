<?php

use yii\helpers\Url;

?>
<div class="modal fade" id="addReportReminderModal" tabindex="-1"
     aria-labelledby="addReportReminderModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReportReminderModalLabel">Додати
                    нагадування</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addReportReminderForm" method="get"
                      action="<?= Url::to(['report/add-report-reminder']) ?>">
                    <input type="hidden"
                           name="reportId"
                           value="<?= $id ?>">

                    <div class="mb-3">
                        <label for="eventDate" class="form-label">
                            <i class="far fa-calendar-alt"></i> Дата події:
                        </label>
                        <input type="date" class="form-control" name="eventDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="event" class="form-label"><i
                                class="fas fa-seedling"></i> Подія:</label>
                        <input aria-label="eventName"
                               type="text" class="form-control"
                               name="eventName" required>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">
                            <i class="fas fa-comment"></i> Коментар:
                        </label>
                        <textarea class="form-control" name="eventComment" rows="3" placeholder="Введіть ваш коментар..."></textarea>
                    </div>
                    <div class="mt-5 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Додати нагадування
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
