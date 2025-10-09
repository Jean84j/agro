<?php

$bigPackageSvg = '<svg width="32px" height="32px">
                        <use xlink:href="/images/sprite.svg#tractor"></use>
                  </svg>';
$smallPackageSvg = '<svg width="28px" height="28px">
                        <use xlink:href="/images/sprite.svg#vily"></use>
                    </svg>';

?>
<div class="sa-invoice__table-container">
    <h4> Оплачені та Повернуті замовлення за період: </h4>
    <br>
    <table class="sa-invoice__table">
        <thead class="sa-invoice__table-head">
        <tr>
            <th class="sa-invoice__table-column--type--quantity">Відділ / Пакування</th>
            <th class="sa-invoice__table-column--type--quantity">К-ть</th>
            <th class="sa-invoice__table-column--type--price">Сума</th>
            <th class="sa-invoice__table-column--type--price">Собі-ть</th>
            <th class="sa-invoice__table-column--type--price">Знижки</th>
            <th class="sa-invoice__table-column--type--price text-center"><i class="fas fa-truck"></i></th>
            <th class="sa-invoice__table-column--type--price">Площадки</th>
            <th class="sa-invoice__table-column--type--total">Приб.</th>
            <th class="sa-invoice__table-column--type--total">Коеф.Нац</th>
            <th class="sa-invoice__table-column--type--total">Марж.</th>
            <th class="sa-invoice__table-column--type--total">NovaPay</th>
        </tr>
        </thead>
        <tbody class="sa-invoice__table-body">
        <tr>
            <td class="sa-invoice__table-column--type--quantity text-center"><?= $bigPackageSvg ?></td>
            <td class="sa-invoice__table-column--type--quantity"><?= $bigQty ?></td>
            <td class="sa-invoice__table-column--type--price"><?= Yii::$app->formatter->asDecimal($bigSum, 2) ?>
                <span class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--price text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigIncomingPriceSum, 2) ?>
                <span class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--price text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigDiscount, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--price text-danger"><span
                        class="sa-price__symbol"></span>-<?= Yii::$app->formatter->asDecimal($bigDelivery, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--price text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigPlatform, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--total"><?= Yii::$app->formatter->asDecimal($bigProfit, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>

            <td class="sa-invoice__table-column--type--total">
                <?= $bigIncomingPriceSum > 0
                    ? Yii::$app->formatter->asDecimal(($bigSum / $bigIncomingPriceSum - 1) * 100, 0) . ' %'
                    : '—'
                ?>
                <span
                        class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--total">
                <?= $bigSum > 0
                    ? Yii::$app->formatter->asDecimal((($bigSum - $bigIncomingPriceSum) / $bigSum) * 100, 0) . ' %'
                    : '—'
                ?>
                <span
                        class="sa-price__symbol"></span></td>


            <td class="sa-invoice__table-column--type--total">
                <?= $bigSum > 0
                    ? Yii::$app->formatter->asDecimal($bigNovaPaySum) : '—'
                ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        <tr>
            <td class="sa-invoice__table-column--type--quantity text-center"><?= $smallPackageSvg ?></td>
            <td class="sa-invoice__table-column--type--quantity"><?= $smallQty ?></td>
            <td class="sa-invoice__table-column--type--price"><?= Yii::$app->formatter->asDecimal($smallSum, 2) ?>
                <span class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--price text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($smallIncomingPriceSum, 2) ?>
                <span class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--price text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($smallDiscount, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--price text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($smallDelivery, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--price text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($smallPlatform, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--total"><?= Yii::$app->formatter->asDecimal($smallProfit, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>

            <td class="sa-invoice__table-column--type--total">
                <?= $smallIncomingPriceSum > 0
                    ? Yii::$app->formatter->asDecimal(($smallSum / $smallIncomingPriceSum - 1) * 100, 0) . ' %'
                    : '—'
                ?>
                <span
                        class="sa-price__symbol"></span></td>
            <td class="sa-invoice__table-column--type--total">
                <?= $smallSum > 0
                    ? Yii::$app->formatter->asDecimal((($smallSum - $smallIncomingPriceSum) / $smallSum) * 100, 0) . ' %'
                    : '—'
                ?>
                <span
                        class="sa-price__symbol"></span></td>


            <td class="sa-invoice__table-column--type--total">
                <?= $smallSum > 0
                    ? Yii::$app->formatter->asDecimal($smallNovaPaySum) : '—'
                ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        </tbody>
        <tbody class="sa-invoice__table-totals">
        <tr>
            <th class="sa-invoice__table-column--type--header" colspan="6">Кількість замовлень</th>
            <td class="sa-invoice__table-column--type--total"><?= $bigQty + $smallQty ?></td>
        </tr>
        <tr>
            <th class="sa-invoice__table-column--type--header" colspan="6">Сума Продажів</th>
            <td class="sa-invoice__table-column--type--total"><?= Yii::$app->formatter->asDecimal($bigSum + $smallSum, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        <tr>
            <th class="sa-invoice__table-column--type--header" colspan="6">Собівартість</th>
            <td class="sa-invoice__table-column--type--total text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigIncomingPriceSum + $smallIncomingPriceSum, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        <tr>
            <th class="sa-invoice__table-column--type--header" colspan="6">NovaPay</th>
            <td class="sa-invoice__table-column--type--total text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigNovaPaySum + $smallNovaPaySum, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        <tr>
            <th class="sa-invoice__table-column--type--header" colspan="6">Коефіцієнт</th>
            <td class="sa-invoice__table-column--type--total">
                <?= ($bigIncomingPriceSum + $smallIncomingPriceSum) > 0
                    ? Yii::$app->formatter->asDecimal((($bigSum + $smallSum) / ($bigIncomingPriceSum + $smallIncomingPriceSum) - 1) * 100, 0) . ' %'
                    : '—'
                ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        <tr>
            <th class="sa-invoice__table-column--type--header" colspan="6">Маржа</th>
            <td class="sa-invoice__table-column--type--total">
                <?= ($bigSum + $smallSum) > 0
                    ? Yii::$app->formatter->asDecimal((($bigSum + $smallSum - $bigIncomingPriceSum - $smallIncomingPriceSum) / ($bigSum + $smallSum)) * 100, 0) . ' %'
                    : '—'
                ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        <tr>
            <th class="sa-invoice__table-column--type--header" colspan="6">Знижки</th>
            <td class="sa-invoice__table-column--type--total text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigDiscount + $smallDiscount, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        <tr>
            <th class="sa-invoice__table-column--type--header" colspan="6">Доставка</th>
            <td class="sa-invoice__table-column--type--total text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigDelivery + $smallDelivery, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        <tr>
            <th class="sa-invoice__table-column--type--header" colspan="6">Платформи</th>
            <td class="sa-invoice__table-column--type--total text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigPlatform + $smallPlatform, 2) ?>
                <span
                        class="sa-price__symbol"></span></td>
        </tr>
        </tbody>
    </table>
</div>
<div class="sa-invoice__total">
    <div class="sa-invoice__total-title">Загальний Прибуток:</div>
    <div class="sa-invoice__total-value"><?= Yii::$app->formatter->asDecimal($bigProfit + $smallProfit, 2) ?>
        <span
                class="sa-price__symbol"> </span></div>
</div>
