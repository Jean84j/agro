<?php

namespace app\widgets;

use yii\base\Widget;
use DateInterval;
use DateTime;

class BaseWidget extends Widget
{
    protected $ukrainianMonths = [
        'Jan' => 'Січ', 'Feb' => 'Лют', 'Mar' => 'Бер',
        'Apr' => 'Кві', 'May' => 'Тра', 'Jun' => 'Чер',
        'Jul' => 'Лип', 'Aug' => 'Сер', 'Sep' => 'Вер',
        'Oct' => 'Жов', 'Nov' => 'Лис', 'Dec' => 'Гру'
    ];

    protected $months = [
        1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
        5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
        9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь',
    ];

    public function getUkrainianMonths()
    {
        return $this->ukrainianMonths;
    }

    public function getMonths()
    {
        return $this->months;
    }

    protected function sortByMonths(array $resultArray): array
    {
        $currentMonth = $this->ukrainianMonths[date('M')] ?? '';

        usort($resultArray, function ($a, $b) use ($currentMonth) {
            $monthsOrder = array_values($this->ukrainianMonths);

            $indexA = array_search($a['label'], $monthsOrder);
            $indexB = array_search($b['label'], $monthsOrder);

            if ($a['label'] === $currentMonth) {
                return 1;
            }
            if ($b['label'] === $currentMonth) {
                return -1;
            }

            return $indexA <=> $indexB;
        });

        return $resultArray;
    }

    public function processCarts(array $carts)
    {
        $resultArray = [];

        foreach ($carts as $item) {
            $label = $item['label'];
            $value = $item['value'];

            if (isset($resultArray[$label])) {
                $resultArray[$label]['value'] += $value;
            } else {
                $resultArray[$label] = [
                    'label' => $label,
                    'value' => $value,
                ];
            }
        }

        return array_values($resultArray);
    }

    /**
     * Метод для получения месяца и года за месяц до текущей даты
     * @return string Форматированный месяц и год
     */
    protected function getPreviousMonthFormatted()
    {
        $currentDate = new DateTime();
        $interval = new DateInterval('P1M');
        $oneMonthAgo = $currentDate->sub($interval);
        $months = $this->months;
        $monthNumber = $oneMonthAgo->format('n');
        $year = $oneMonthAgo->format('Y');
        $monthName = $months[$monthNumber];

        return $monthName . ' ' . $year;
    }

}
