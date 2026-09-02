<?php

use yii\helpers\Url;

?>
<!--<div class="sa-suggestions__section">-->
<!--    <div class="sa-suggestions__section-title">Actions</div>-->
<!--    <div class="sa-suggestions__item sa-suggestions__item--type--default">Add new product</div>-->
<!--</div>-->

<div class="sa-suggestions__section">
    <?php if (!empty($categories)): ?>
        <div class="sa-suggestions__section-title">
            <span class="sa-nav__icon">
                   <svg width="16px" height="16px" style="display: unset;">
                         <use xlink:href="/admin/images/sprite.svg#categories"/>
                   </svg>
            </span>
            <span> КАТЕГОРІЇ</span>
        </div>
        <?php foreach ($categories as $category): ?>
            <div class="sa-suggestions__item sa-suggestions__item--type--product">
                <div class="sa-suggestions__product">
                    <div class="sa-suggestions__product-image">
                        <?php if (isset($category->file)): ?>
                            <img src="<?= Yii::$app->request->hostInfo . '/images/category/' . $category->file ?>"
                                 width="40" height="40" alt=""/>
                        <?php else: ?>
                            <img src="<?= Yii::$app->request->hostInfo . '/images/no-image.png' ?>"
                                 width="40" height="40" alt=""/>
                        <?php endif; ?>
                    </div>
                    <div class="sa-suggestions__product-info">
                        <a href="<?= Url::to(['category/update', 'id' => $category->id]) ?>">
                            <div class="sa-suggestions__product-name"><?= $category->name ?></div>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (!empty($products)): ?>
        <div class="sa-suggestions__section-title">
            <span class="sa-nav__icon">
                <svg width="16px" height="16px" style="display: unset;">
                    <use xlink:href="/admin/images/sprite.svg#products"/>
                </svg>
            </span>
            <span> ТОВАРИ</span>
        </div>
        <?php foreach ($products as $product): ?>
            <div class="sa-suggestions__item sa-suggestions__item--type--product">
                <div class="sa-suggestions__product">
                    <div class="sa-suggestions__product-image">
                        <?php if (isset($product->images[0])): ?>
                            <img src="<?= Yii::$app->request->hostInfo . '/product/' . $product->images[0]->extra_small ?>"
                                 width="40" height="40" alt=""/>
                        <?php else: ?>
                            <img src="<?= Yii::$app->request->hostInfo . '/images/no-image.png' ?>"
                                 width="40" height="40" alt=""/>
                        <?php endif; ?></div>
                    <div class="sa-suggestions__product-info">
                        <a href="<?= Url::to(['product/update', 'id' => $product->id]) ?>">
                            <div class="sa-suggestions__product-name"><?= $product->name ?></div>
                        </a>
                        <div class="sa-suggestions__product-meta sa-meta">
                            <ul class="sa-meta__list">
                                <li class="sa-meta__item"><?= $product->sku ?></li>
                                <li class="sa-meta__item"><?= $product->price ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (!empty($reports)): ?>
        <div class="sa-suggestions__section-title">
           <span class="sa-nav__icon">
               <svg width="16px" height="16px" style="display: unset;">
                   <use xlink:href="/admin/images/sprite.svg#report"/>
               </svg>
           </span>
            <span> ЗВІТ</span>
        </div>
        <?php foreach ($reports as $report): ?>
            <div class="sa-suggestions__item sa-suggestions__item--type--product">
                <div class="sa-suggestions__product">
                    <div class="sa-suggestions__product-image">
                        <?php
                        $status = trim($report->order_status_id ?? '');

                        $statusMap = [
                            'Одержано' => ['file' => 'order-done.jpg', 'alt' => 'Одержано'],
                            'Повернення' => ['file' => 'order-return.jpg', 'alt' => 'Повернення'],
                            'Відміна' => ['file' => 'order-cancel.jpg', 'alt' => 'Відміна'],
                            'Очікується' => ['file' => 'order-expected.jpg', 'alt' => 'Очікується'],
                            'Комплектується' => ['file' => 'order-completed.jpg', 'alt' => 'Комплектується'],
                            'Доставляється' => ['file' => 'order-delivered.jpg', 'alt' => 'Доставляється'],
                        ];

                        $default = ['file' => 'order-none.jpg', 'alt' => $status !== '' ? 'Статус не визначено' : 'Статус отсутствует'];

                        $imageInfo = $statusMap[$status] ?? $default;
                        $src = Yii::$app->request->hostInfo . '/admin/images/suggestions/' . $imageInfo['file'];
                        ?>

                        <img src="<?= $src ?>" width="40" height="40" alt="<?= $imageInfo['alt'] ?>"/></div>
                    <div class="sa-suggestions__product-info">
                        <a href="<?= Url::to(['report/view', 'id' => $report->id]) ?>">
                            <div class="sa-suggestions__product-name" style="color: black"><?= $report->fio ?></div>
                        </a>
                        <div class="sa-suggestions__product-meta sa-meta">
                            <ul class="sa-meta__list">
                                <li class="sa-meta__item"><?= $report->number_order ?></li>
                                <li class="sa-meta__item"><?= $report->tel_number ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!--    <div class="sa-suggestions__item sa-suggestions__item--type--link">Show all 10 results</div>-->
</div>