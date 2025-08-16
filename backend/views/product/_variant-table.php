<?php


?>
<tbody id="variant-table">
<?php if (!empty($variants)) : ?>
    <?php foreach ($variants as $variant) : ?>
        <tr>
            <td>
                <input type="text" name="variant[<?= $variant['id'] ?>]"
                       class="form-control form-control-sm"
                       value="<?= $variant['name'] ?>" readonly/>
            </td>
            <td>
                <input type="text" name="volume[<?= $variant['id'] ?>]"
                       class="form-control form-control-sm wx-4x"
                       value="<?= $variant['volume'] ?>" readonly/>
            </td>
            <td>
                <a href="#"
                   id="<?= $variant['id'] ?>"
                   data-productId="<?= $id ?>"
                   data-variantId="<?= $variant['product_variant_id'] ?>"

                   class="text-danger del-variant"
                   onclick="return confirm('Вы уверены, что хотите удалить этот товар из заказа?')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                         height="12" viewBox="0 0 12 12" fill="currentColor">
                        <path d="M10.8,10.8L10.8,10.8c-0.4,0.4-1,0.4-1.4,0L6,7.4l-3.4,3.4c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L4.6,6L1.2,2.6 c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L6,4.6l3.4-3.4c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L7.4,6l3.4,3.4 C11.2,9.8,11.2,10.4,10.8,10.8z"></path>
                    </svg>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>
