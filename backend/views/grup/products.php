<?php

use yii\helpers\Url;

/** @var backend\controllers\GrupController $products */

?>
<div class="card">
    <div class="card-body">
        <table class="table table-striped mb-0">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Фото</th>
                <th scope="col">Товар</th>
                <th scope="col">Категорія</th>
                <th scope="col">Статус</th>
                <th scope="col">*</th>
            </tr>
            </thead>
            <tbody id="table-products">
            <?php
            $i = 1;
            foreach ($products as $product): ?>
                <?php switch ($product->status_id) {
                    case 1:
                        $color = 'success';
                        break;
                    case 2:
                        $color = 'danger';
                        break;
                    case 3:
                        $color = 'warning';
                        break;
                    case 4:
                        $color = 'info';
                        break;

                    default:
                        $color = 'secondary';
                } ?>

                <tr>
                    <td><?= $i ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="#" class="me-4">
                                <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--size--lg">
                                    <img src="<?= isset($product->images[0])
                                        ? Url::to('/product/' . $product->images[0]->extra_small, true)
                                        : Url::to('/images/no-image.png', true) ?>"
                                         width="40" height="40" alt=""/>
                                </div>
                            </a>
                        </div>
                    </td>

                    <td>
                        <?php
                        $url = Url::to(['product/update', 'id' => $product->id]);
                        ?>
                        <a href="<?= $url ?>" class="text-reset" style="font-weight: bold;">
                            <?= $product->name ?>
                        </a>
                    </td>

                    <td>
                        <?= $product->category->name ?>
                    </td>

                    <td>
                        <?= '<div class="badge badge-sa-' . $color . '">' . $product->status->name ?? '—' . '</div>' ?>
                    </td>

                    <td>
                        <div class="text-muted fs-exact-14">
                            <a href="<?= Url::to(['grup/delete-product-group']) ?>"
                               data-id="<?= $groupId; ?>"
                               data-product-id="<?= $product->id; ?>"
                               class="text-danger delete-product">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>

                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$js = <<<JS

$(document).on('click', '.delete-product', function(e) {
    e.preventDefault();
    
    const btn = $(this);
    const groupId = btn.data('id');
    const productId = btn.data('productId');
    const url = btn.attr('href');
 
    $.ajax({
        url: url,
        type: 'POST',
        data: { 
            id: groupId,
            productId: productId
        },
        success: function(response) {
            if (response.success) {
                document.getElementById('table-products').innerHTML = response.group;
            } else {
                alert(response.error || 'Ошибка при удалении.');
            }
        },
        error: function() {
            alert('Произошла ошибка при удалении.');
        }
    });

    return false;
});

JS;

$this->registerJs($js);
?>