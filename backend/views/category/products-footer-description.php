<?php

use vova07\imperavi\Widget;

?>
<div class="card mt-5">
    <div class="card-header">
        <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"> <h2
                                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'Products footer description') ?></h2></span>

        </div>
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="uk-products_footer-description-2"
                    data-bs-toggle="tab"
                    data-bs-target="#uk-products_footer-description-content-2"
                    type="button"
                    role="tab"
                    aria-controls="uk-tab-content-2"
                    aria-selected="true"
                >
                    UK<span class="nav-link-sa-indicator"></span>
                </button>
            </li>
            <?php if (isset($translateRu)): ?>
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link"
                        id="ru-products_footer-description-2"
                        data-bs-toggle="tab"
                        data-bs-target="#ru-products_footer-description-content-2"
                        type="button"
                        role="tab"
                        aria-controls="ru-products_footer-description-content-2"
                        aria-selected="true"
                    >
                        RU<span class="nav-link-sa-indicator"></span>
                    </button>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div
                class="tab-pane fade show active"
                id="uk-products_footer-description-content-2"
                role="tabpanel"
                aria-labelledby="uk-products_footer-description-2">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'footer description') ?> UK</h2></span>
                        </div>
                        <div class="mb-4">
                            <?= $form->field($model, 'product_footer_description')->widget(Widget::class, [
                                'options' => ['id' => 'uk-footer_description'],
                                'defaultSettings' => [
                                    'style' => 'position: unset;'
                                ],
                                'settings' => [
                                    'lang' => 'uk',
                                    'minHeight' => 100,
                                    'plugins' => [
                                        'fullscreen',
                                        'table',
                                        'clips',
                                    ],
                                    'clips' => [
                                        ['Footer Descr...', '
                                                        <p>---------------------------
                                                        </p>
                                                        <p><strong>Увага!!!</strong>  
                                                        Для безпечного використання препарату (*name_product*) 
                                                        та досягнення максимальної ефективності його дії, 
                                                        слід строго дотримуватися інструкцій виробника та правил техніки 
                                                        безпеки при обробці хімічних речовин.
                                                        </p>
                                                        <p>Інтернет-магазин <a href="https://agropro.org.ua/">AgroPro</a> 
                                                        пропонує одні з найвигідніших цін на (*name_product*). 
                                                        Ви можете купити необхідний препарат на нашому веб-сайті, 
                                                        і наші менеджери оперативно оброблять та доставлять ваше замовлення.
                                                        </p>
                                                        <p>Наші модератори дуже уважно перевіряють інформацію, 
                                                        перед тим як публікувати її на сайті. Однак, на жаль, 
                                                        дані про товар можуть змінюватися виробником без попередження, 
                                                        тому інтернет-магазин <a href="https://agropro.org.ua/">AgroPro</a> 
                                                        не несе відповідальності за точність опису, 
                                                        і наявна помилка не може служити підставою для повернення товару.
                                                        </p>'
                                        ],
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="ru-products_footer-description-content-2"
                role="tabpanel"
                aria-labelledby="ru-products_footer-description-2">
                <div class="card">
                    <?php if (isset($translateRu)): ?>
                        <div class="card-body p-5">
                            <div class="mb-5">
                                    <span class="sa-nav__menu-item-badge badge badge-sa-pill badge-sa-theme-cart"><h2
                                            class="mb-0 fs-exact-18"><?= Yii::t('app', 'products footer description') ?> RU</h2></span>
                            </div>
                            <div class="mb-4">
                                <?= $form->field($translateRu, 'product_footer_description')->widget(Widget::class, [
                                    'options' => ['id' => 'ru-footer_description', 'name' => 'CategoriesTranslate[ru][product_footer_description]'],
                                    'defaultSettings' => [
                                        'style' => 'position: unset;'
                                    ],
                                    'settings' => [
                                        'lang' => 'uk',
                                        'minHeight' => 100,
                                        'plugins' => [
                                            'fullscreen',
                                            'table',
                                            'clips',
                                        ],
                                    ],
                                ]); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
