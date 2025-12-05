<?php

/** @var  $tabs */
/** @var  $params */

?>
<ul class="nav nav-tabs" role="tablist">
    <?php foreach ($tabs as $tab): ?>
        <li class="nav-item" role="presentation">
            <button
                    class="nav-link <?= !empty($tab['active']) ? 'active' : '' ?>"
                    id="<?= $tab['id'] ?>-tab-1"
                    data-bs-toggle="tab"
                    data-bs-target="#<?= $tab['id'] ?>-tab-content-1"
                    type="button"
                    role="tab"
                    aria-controls="<?= $tab['id'] ?>-tab-content-1"
                    aria-selected="<?= !empty($tab['active']) ? 'true' : 'false' ?>"
            >
                                            <span class="text-center-info">
                                                <i class="<?= $tab['icon'] ?> color-info"></i>
                                                <span><?= $tab['label'] ?></span>
                                            </span>
                <span class="nav-link-sa-indicator"></span>
            </button>
        </li>
    <?php endforeach; ?>
</ul>
<div class="tab-content mt-4">
    <?php foreach ($tabs as $tab): ?>
        <div
                class="tab-pane fade <?= !empty($tab['active']) ? 'show active' : '' ?>"
                id="<?= $tab['id'] ?>-tab-content-1"
                role="tabpanel"
                aria-labelledby="<?= $tab['id'] ?>-tab-1"
        >
            <?= $this->render($tab['view'], $params) ?>
        </div>
    <?php endforeach; ?>
</div>