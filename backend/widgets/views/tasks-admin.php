<?php

/** @var array $tasks */

?>
<button
        class="sa-toolbar__button"
        type="button"
        id="dropdownMenuButtonTasks"
        data-bs-toggle="dropdown"
        data-bs-reference="parent"
        data-bs-offset="0,1"
        aria-expanded="false"
>
    <svg width="20px" height="20px" style="display: unset; font-size: larger; color: rgb(255,88,88)">
        <use xlink:href="/admin/images/sprite.svg#tasks-admin"/>
    </svg>
    <span class="sa-toolbar__button-indicator"><?= count($tasks) ?></span>
</button>
<div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="dropdownMenuButtonTasks">
    <div class="sa-notifications">
        <div class="sa-notifications__header">
            <div class="sa-notifications__header-title">Повідомлення</div>
            <!--            <a class="sa-notifications__header-action" href="/">До задач...</a>-->
        </div>
        <ul class="sa-notifications__list">
            <?php foreach ($tasks as $task): ?>
                <li class="sa-notifications__item">
                    <a href="#" class="sa-notifications__item-button">
                        <div class="sa-notifications__item-icon">
                            <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--style--primary">
                                <div class="sa-symbol__icon">
                                    <svg width="16px" height="16px" style="display: unset">
                                        <use xlink:href="/admin/images/sprite.svg#<?= $task['svg'] ?>"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="sa-notifications__item-body">
                            <div class="sa-notifications__item-title sa-notifications__item-title--nowrap">
                                <?= $task['title'] ?>
                            </div>
                            <div class="sa-notifications__item-subtitle sa-notifications__item-subtitle--nowrap">
                                <?= $task['descr'] ?>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
