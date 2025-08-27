<?php ?>
<div class="modal fade" id="addWordsModal" tabindex="-1"
     aria-labelledby="addWordsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWordsModalLabel">+
                    SEO слова </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="productId"
                       value="<?= $model->id ?>">
                <input type="hidden" name="categoryId"
                       value="<?= $model->category_id ?>">

                <div class="mb-3">
                    <label for="">UK</label>
                    <input type="text" class="form-control"
                           id="wordUk"
                           name="wordUk"
                           value=""
                    >
                </div>

                <div class="mb-3">
                    <label for="">RU</label>
                    <input type="text" class="form-control"
                           id="wordRu"
                           name="wordRu"
                           value=""
                    >
                </div>

                <div class="mt-5 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="submitWordsBtn">Додати
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
