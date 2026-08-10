<?php

use yii\helpers\Url;

/** @var  $orders */
/** @var  $total_summ */
/** @var  $minimumOrderAmount */

if (empty($orders)): ?>
    <div class="checkout__empty-cart text-center py-5" style="border: 1px dashed #ddd; border-radius: 8px;">
        <div class="mb-4">
            <i class="fas fa-shopping-cart fa-5x" style="color: #ccc;"></i>
        </div>

        <h3 class="mb-3 text-muted"><?= Yii::t('app', 'На жаль, ваш кошик порожній') ?></h3>

        <p class="mb-4 text-muted" style="max-width: 400px; margin-left: auto; margin-right: auto;">
            <?= Yii::t('app', 'Не хвилюйтеся, у нас є багато чудових товарів! Перегляньте наш каталог, щоб знайти те, що вам потрібно.') ?>
        </p>

        <a href="<?= Url::to(['/catalog']) ?>" class="btn btn-primary btn-lg shadow_element">
            <?= Yii::t('app', 'Продовжити покупки') ?>
        </a>

        <div class="mt-5 text-muted">
            <small>
                <?= Yii::t('app', 'Потрібна допомога? ') ?>
                <a href="<?= Url::to(['/contact']) ?>" class="font-weight-bold"><?= Yii::t('app', 'Зв\'яжіться з нами') ?></a>
            </small>
        </div>
    </div>
    <?php return; endif; ?>

<?php
$disableMinAmount = '';
$classButton = 'btn-primary';
$textButton = Yii::t('app', 'Зробити замовлення');

if ($total_summ < $minimumOrderAmount->amount) {
    $disableMinAmount = 'disabled';
    $classButton = 'btn-outline-danger';
    $textButton = '<span style="color: #CE272D; font-weight: bold;">' .
        Yii::t('app', 'Замовлення від') . ' ' .
        $minimumOrderAmount->amount . ' ₴</span>';
}
?>

<div id="orders-total">
    <table class="checkout__totals">
        <thead class="checkout__totals-header">
        <tr>
            <th><i class="fas fa-image"></i></th>
            <th><?= Yii::t('app', 'Товар') ?></th>
            <th><?= Yii::t('app', 'К-ть') ?></th>
            <th><?= Yii::t('app', 'Всього') ?></th>
        </tr>
        </thead>
        <tbody class="checkout__totals-products">
        <?php foreach ($orders as $order): ?>
            <tr>
                <td style="width: 1%; white-space: nowrap; padding: 0;">
                    <img src="<?= $order->getImgOne($order->getId()) ?>"
                         width="30" height="30"
                         alt="<?= $order->name ?>"
                         style="display: block;">
                </td>
                <td><?= $order->name ?></td>
                <td><?= $order->quantity ?></td>
                <td><?= Yii::$app->formatter->asCurrency($order->getPrice() * $order->quantity) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot class="checkout__totals-footer">
        <tr>
            <th><?= Yii::t('app', 'Разом') ?></th>
            <td><?= Yii::$app->formatter->asCurrency($total_summ) ?></td>
        </tr>
        </tfoot>
    </table>

    <div class="checkout__agree form-group">
        <div class="form-check">
            <span id="check-red" class="form-check-input input-check">
                <span class="input-check__body shadow_element">
                    <input class="input-check__input" type="checkbox"
                           id="checkout-terms" checked <?= $disableMinAmount ?>>
                    <span class="input-check__box"></span>
                    <svg class="input-check__icon" width="9px" height="7px">
                        <use xlink:href="/images/sprite.svg#check-9x7"></use>
                    </svg>
                </span>
            </span>
            <label class="form-check-label" for="checkout-terms">
                <?= Yii::t('app', 'Я прочитав ') ?>
                <a style="font-weight: bold" target="_blank" href="<?= Url::to(['/order/conditions']) ?>">
                    <?= Yii::t('app', ' умови повернення та обміну') ?>
                </a><span style="color: red">*</span>
                <?= Yii::t('app', ' та погоджуюся з інтернет-магазином') ?>
                <span style="font-weight: bold"> AgroPro</span>
            </label>
        </div>
    </div>

    <button type="submit" id="orderTo" class="btn btn-dec-lg btn-block shadow_element <?= $classButton ?>" <?= $disableMinAmount ?>
            style="font-size: 16px"><?= $textButton ?>
    </button>
</div>