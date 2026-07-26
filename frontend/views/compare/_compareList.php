<?php

/** @var  $products */
/** @var  $properties */

?>
<?= $this->render('block',
    [
        'properties' => $properties,
        'products' => $products,
    ]) ?>