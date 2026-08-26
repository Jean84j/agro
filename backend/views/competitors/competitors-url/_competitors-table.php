<?php

use yii\helpers\Url;

?>
<tbody id="competitors-table">
<?php if (isset($competitors)): ?>

    <?php foreach ($competitors as $competitor): ?>
        <tr>
            <td><?= $competitor['id'] ?></td>
            <td><?= $competitor['url'] ?></td>
            <td><?= 'Price' ?></td>
            <td class="text-center align-middle">

            </td>
            <td class="text-end">
                <div class="text-muted fs-exact-14">
                    <a href="#" data-bs-toggle="modal"
                       data-bs-target="#editCompetitorModal<?= $competitor['id'] ?>">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
                <!-- Удаление -->
                <div class="text-muted fs-exact-14">
                    <a href="<?= Url::to(['competitors/delete-competitor']) ?>"
                       data-id="<?= $competitor['id'] ?>"
                       data-product-id="<?= $competitor['product_id'] ?>"
                       class="text-danger delete-competitor"
                       onclick="return confirm('Вы уверены, что хотите удалить этот товар из заказа?')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>
            </td>
        </tr>
        <?php echo $this->render('modal-edit-competitor', ['model' => $model, 'competitor' => $competitor]); ?>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>
