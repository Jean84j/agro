<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\shop\ActivePages;

class ActiveUsersSite extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $startDate = date('Y-m-01 00:00:00', strtotime('-11 months'));
        $endDate = date('Y-m-t 23:59:59');

        $users = ActivePages::find()
            ->select('date_visit')
            ->orderBy(['date_visit' => SORT_ASC])
            ->andWhere(['between', 'date_visit', strtotime($startDate), strtotime($endDate)])
            ->all();

        $carts = [];
        $ukrainian_months = $this->getUkrainianMonths();

        foreach ($users as $user) {
            $month_name = date('M', $user->date_visit);
            $ukrainian_month_name = $ukrainian_months[$month_name] ?? '';
            $carts[] = [
                "label" => $ukrainian_month_name,
                "value" => 1,
            ];
        }

        $resultArray = $this->processCarts($carts);

        $resultArray = $this->sortByMonths($resultArray);

        return $this->render('active-users-site', ['resultArray' => json_encode($resultArray)]);
    }
}
