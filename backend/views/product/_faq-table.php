<?php

use backend\models\ProductsBackend;
use yii\helpers\Url;

?>
<tbody id="faq-table">
<?php if (isset($faq)): ?>
<?php  $model = ProductsBackend::findOne($id); ?>

    <?php foreach ($faq as $question): ?>
        <tr>
            <td><?= $question['id'] ?></td>
            <td><?= $question['question'] ?></td>
            <td><?= $question['answer'] ?></td>
            <td class="text-center align-middle">
                <label class="form-check form-switch">
                    <input type="checkbox" class="form-check-input is-valid checkbox-lg"
                           id="<?= $question['id'] ?>"
                           data-id="<?= $question['id'] ?>"
                           data-product-id="<?= $model->id ?>"
                        <?= $question['visible'] == 1 ? 'checked' : '' ?>
                    />
                </label>
            </td>
            <td class="text-end">
                <div class="text-muted fs-exact-14">
                    <a href="#" data-bs-toggle="modal"
                       data-bs-target="#editFaqModal<?= $question['id'] ?>">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
                <!-- Удаление -->
                <div class="text-muted fs-exact-14">
                    <a href="<?= Url::to(['product/delete-product-faq']) ?>"
                       data-id="<?= $question['id'] ?>"
                       data-product-id="<?= $id ?>"
                       class="text-danger delete-faq"
                       onclick="return confirm('Вы уверены, что хотите удалить этот товар из заказа?')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>
            </td>
        </tr>
        <?php echo $this->render('modal-edit-faq', ['model' => $model, 'faq' => $question]); ?>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>
