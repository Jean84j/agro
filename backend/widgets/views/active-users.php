<?php

use common\models\shop\ActivePages;

$url = '';

?>

<div class="col-12 col-lg-4 col-xxl-3 d-flex">
    <div class="card flex-grow-1 saw-pulse" data-sa-container-query='{"560":"saw-pulse--size--lg"}'>
        <div class="sa-widget-header saw-pulse__header">
            <h2 class="sa-widget-header__title">Активніcть користувачів</h2>
            <div class="sa-widget-header__actions">
                <div class="dropdown">
                    <button
                        type="button"
                        class="btn btn-sm btn-sa-muted d-block"
                        id="widget-context-menu-4"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        aria-label="More"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="3" height="13" fill="currentColor">
                            <path
                                d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z"
                            ></path>
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="widget-context-menu-4">
                        <li><a class="dropdown-item" href="/#">Settings</a></li>
                        <li><a class="dropdown-item" href="/#">Move</a></li>
                        <li>
                            <hr class="dropdown-divider"/>
                        </li>
                        <li><a class="dropdown-item text-danger" href="/#">Remove</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="saw-pulse__counter"><?= ActivePages::countIpUsers() ?></div>
        <div class="sa-widget-table saw-pulse__table">
            <table>
                <thead>
                <tr>
                    <th>Активні сторінки</th>
                    <th class="text-end">Переглядів</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="/" class="text-reset">Головна /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = '/')?></span></td>
                </tr>
                <tr>
                    <td><a href="/catalog" class="text-reset">Каталог /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = 'catalog') ?></span></td>
                </tr>
                <tr>
                    <td><a href="/" class="text-reset">Продукти /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = 'product') ?></span></td>
                </tr>
                <tr>
                    <td><a href="/blogs/view" class="text-reset">Статті /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = 'post') ?></span></td>
                </tr>
                <tr>
                    <td><a href="/" class="text-reset">Корзина /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = 'cart') ?></span></td>
                </tr>
                <tr>
                    <td><a href="/" class="text-reset">Замовлення /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = 'order') ?></span></td>
                </tr>
                <tr>
                    <td><a href="/special/view" class="text-reset">Спец пропозиції /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = 'special') ?></span></td>
                </tr>
                <tr>
                    <td><a href="/contact/view" class="text-reset">Зв'язок з нами /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = 'contact') ?></span></td>
                </tr>
                <tr>
                    <td><a href="/delivery/view" class="text-reset">Доставка оплата /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = 'delivery') ?></span></td>
                </tr>
                <tr>
                    <td><a href="/about" class="text-reset">Про нас /</a></td>
                    <td class="text-end"><span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-user"><?= ActivePages::countViewsPage($url = 'about') ?></span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>