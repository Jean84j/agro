<?php

use yii\helpers\Url;

?>
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
                   data-id="<?= $id; ?>"
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
