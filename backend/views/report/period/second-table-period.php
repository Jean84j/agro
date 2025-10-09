<?php

use yii\helpers\Html;
use yii\helpers\Url;

$bigPackageSvg = '<svg width="32px" height="32px">
                        <use xlink:href="/images/sprite.svg#tractor"></use>
                  </svg>';
$smallPackageSvg = '<svg width="28px" height="28px">
                        <use xlink:href="/images/sprite.svg#vily"></use>
                    </svg>';

?>
<div class="sa-invoice__sides">
    <div class="sa-invoice__table-container">
        <div class="row" style="--bs-gutter-x: 0rem; padding-top: 5px">
            <div class="col-auto d-flex">
                <h4> Всі замовлення за період:</h4>
                <?= Html::a(Yii::t('app', '<i class="far fa-file-excel"></i> Excel Всі'), Url::to(['report-export-to-excel']), ['class' => 'btn btn-outline-success', 'style' => 'margin-left: 20px;']) ?>
                <?= Html::a(Yii::t('app', '<i class="far fa-file-excel"></i> Excel Фермер'), Url::to(['report-export-to-excel', 'package' => 'BIG']), ['class' => 'btn btn-outline-info', 'style' => 'margin-left: 20px;']) ?>
                <?= Html::a(Yii::t('app', '<i class="far fa-file-excel"></i> Excel Дрібна'), Url::to(['report-export-to-excel', 'package' => 'SMALL']), ['class' => 'btn btn-outline-primary', 'style' => 'margin-left: 20px;']) ?>
            </div>
        </div>
        <br>
        <table class="sa-invoice__table">
            <thead class="sa-invoice__table-head">
            <tr>
                <th class="sa-invoice__table-column--type--product">Відділ / Пакування</th>
                <th class="sa-invoice__table-column--type--product"></th>
                <th class="sa-invoice__table-column--type--quantity">Замов.</th>
                <th class="sa-invoice__table-column--type--quantity">Повер.</th>
                <th class="sa-invoice__table-column--type--price">Сума</th>
            </tr>
            </thead>
            <tbody class="sa-invoice__table-body">
            <tr>
                <td class="sa-invoice__table-column--type--product"><?= $bigPackageSvg ?></td>
                <td class="sa-invoice__table-column--type--product"></td>
                <td class="sa-invoice__table-column--type--quantity"><?= $bigAllQty ?></td>
                <td class="sa-invoice__table-column--type--quantity"><?= $bigAllReturnQty ?></td>
                <td class="sa-invoice__table-column--type--price"><?= Yii::$app->formatter->asDecimal($bigAllSum, 2) ?>
                    <span class="sa-price__symbol"></span></td>
            </tr>
            <tr>
                <td class="sa-invoice__table-column--type--product"><?= $smallPackageSvg ?></td>
                <td class="sa-invoice__table-column--type--product"></td>
                <td class="sa-invoice__table-column--type--quantity"><?= $smallAllQty ?></td>
                <td class="sa-invoice__table-column--type--quantity"><?= $smallAllReturnQty ?></td>
                <td class="sa-invoice__table-column--type--price"><?= Yii::$app->formatter->asDecimal($smallAllSum, 2) ?>
                    <span class="sa-price__symbol"></span></td>
            </tr>
            </tbody>
            <tbody class="sa-invoice__table-totals">
            <tr>
                <th class="sa-invoice__table-column--type--header" colspan="3">Кількість замовлень:</th>
                <td class="sa-invoice__table-column--type--total"><?= ($bigAllQty + $smallAllQty) - ($smallAllReturnQty + $bigAllReturnQty) ?></td>
            </tr>
            <tr>
                <th class="sa-invoice__table-column--type--header" colspan="3">Доставка:</th>
                <td class="sa-invoice__table-column--type--total text-danger"><span
                        class="sa-price__symbol">-</span><?= Yii::$app->formatter->asDecimal($bigAllDelivery + $smallAllDelivery, 2) ?>
                    <span
                        class="sa-price__symbol"> ₴</span></td>
            </tr>
            <tr>
                <th class="sa-invoice__table-column--type--header" colspan="3">Сума Продажів:</th>
                <td class="sa-invoice__table-column--type--total"
                    style="font-weight: bold"><?= Yii::$app->formatter->asDecimal(($bigAllSum + $smallAllSum) - ($bigAllDelivery + $smallAllDelivery), 2) ?>
                    <span
                        class="sa-price__symbol"> ₴</span></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
