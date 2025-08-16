<?php

namespace backend\widgets;

use common\models\Report;
use DateInterval;
use DateTime;
use yii\base\Widget;

class ReportPlatform extends Widget
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {

        $currentDate = new DateTime();

        $lastYearDate = $currentDate->sub(new DateInterval('P12M'))->format('Y-m-d');

        $platformCounts = array_count_values(
            array_column(
                Report::find()
                    ->select('platform')
                    ->where(['order_pay_ment_id' => 'Оплачено'])
                    ->andWhere(['>=', 'date_order', $lastYearDate])  // Фильтрация по дате
                    ->asArray()
                    ->all(),
                'platform'
            )
        );

        arsort($platformCounts);

        $carts = array_slice(array_map(function ($platformName, $platformCount) {
            return [
                "label" => $platformName,
                "value" => $platformCount,
            ];
        }, array_keys($platformCounts), $platformCounts), 0, 8);

        $colors = [
            10 => '#0cdd9d',
            9 => '#bb43df',
            8 => '#198754',
            7 => '#6f42c1',
            6 => '#f907ed',
            5 => '#ffd333',
            4 => '#e62e2e',
            3 => '#29cccc',
            2 => '#3377ff',
            1 => '#5dc728',
            0 => '#fd7e14',
        ];

        foreach ($carts as $index => &$cart) {
            $cart['color'] = $colors[$index % count($colors)];
        }
        unset($cart);

        return $this->render('report-platform', [
            'platforms' => $carts,
            'carts' => json_encode($carts),
            'title' => 'Платформи',
        ]);
    }

}