<?php

use yii\helpers\Html;
use yii\helpers\Url;


?>

            <div class="cart block">
                <div class="container">
                    <table class="cart__table cart-table">
                        <thead class="cart-table__head">
                        <tr class="cart-table__row">
                            <th class="cart-table__column cart-table__column--image">Зображення</th>
                            <th class="cart-table__column cart-table__column--product">Товар</th>
                            <th class="cart-table__column cart-table__column--price">Ціна</th>
                            <th class="cart-table__column cart-table__column--quantity">К-ть</th>
                            <th class="cart-table__column cart-table__column--total">Всього</th>
                            <th class="cart-table__column cart-table__column--remove"></th>
                        </tr>
                        </thead>
                        <tbody class="cart-table__body">
                        <?php foreach ($orders as $order): ?>
                        <tr class="cart-table__row">
                            <td class="cart-table__column cart-table__column--image">
                                <div class="product-image">
                                    <a href="<?=Url::to(['product/view', 'slug' => $order->slug])?>" class="product-image__body">
                                        <img class="product-image__img" src="/product/<?= $order->images[0]->name?>" alt="">
                                    </a>
                                </div>
                            </td>
                            <td class="cart-table__column cart-table__column--product">
                                <a href="<?=Url::to(['product/view', 'slug' => $order->slug])?>" class="cart-table__product-name"><?=$order->name?></a>
                            </td>
                            <td class="cart-table__column cart-table__column--price" data-title="Price"><?=Yii::$app->formatter->asCurrency($order->price)?></td>
                            <td class="cart-table__column cart-table__column--quantity" data-title="Quantity">
                                <div class="input-number">
                                    <input class="form-control input-number__input" type="number" min="1" value="<?=$order->getQuantity()?>"
                                           onchange="updateQty(<?= $order->getId()?>, $(this).val());" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();">
                                    <div class="input-number__add" onclick="updateQty(<?= $order->getId()?>, <?= $order->getQuantity() + 1?>)"></div>
                                    <div class="input-number__sub" onclick="updateQty(<?= $order->getId()?>, <?= $order->getQuantity() - 1?>)"></div>
                                </div>
                            </td>
                            <td class="cart-table__column cart-table__column--total" data-title="Total"><?=Yii::$app->formatter->asCurrency($order->price * $order->getQuantity())?></td>
                            <td class="cart-table__column cart-table__column--remove" onclick="removeProduct(<?=$order->id?>)">
                                <button type="button" class="btn btn-light btn-sm btn-svg-icon">
                                    <svg width="12px" height="12px">
                                        <use xlink:href="/images/sprite.svg#cross-12"></use>
                                    </svg>
                                </button>
                                <?php // Html::a('
//                            <button type="button" class="btn btn-light btn-sm btn-svg-icon">
//                                    <svg width="12px" height="12px">
//                                        <use xlink:href="/images/sprite.svg#cross-12"></use>
//                                    </svg>
//                                </button>',
//                                    Url::to(['cart/remove', 'id' => $order->getId()]),
//                                    ['class' => 'reset-quantity',
//                                        'data' => [
//                                            'method' => 'post',
//                                            'pjax' => 1,
//                                        ],
//                                    ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="row justify-content-end pt-5">
                        <div class="col-12 col-md-7 col-lg-6 col-xl-5">
                            <div class="card">
                                <div class="card-body">
<!--                                    <h3 class="card-title">Cart Totals</h3>-->
                                    <table class="cart__totals">
                                        <tfoot class="cart__totals-footer">
                                        <tr>
                                            <th>Загальна сума</th>
                                            <td><?=Yii::$app->formatter->asCurrency($total_summ)?></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <a class="btn btn-primary btn-xl btn-block cart__checkout-button" href="checkout.html">Замовити</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

