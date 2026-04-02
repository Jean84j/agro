<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\shop\ActivePages;

class ActiveUsersSiteDayOld extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $dateFrom = strtotime('-1 year -30 days midnight');
        $dateTo   = strtotime('-1 year 23:59:59');

        $users = ActivePages::find()
            ->select('date_visit')
            ->where(['>=', 'date_visit', $dateFrom])
            ->andWhere(['<=', 'date_visit', $dateTo])
            ->orderBy(['date_visit' => SORT_ASC])
            ->asArray()
            ->all();

        $carts = [];
        $ukrainian_months = $this->getUkrainianMonths();

        foreach ($users as $user) {
            $month_name = date('M', $user['date_visit']);
            $day = date('j', $user['date_visit']);
            $ukrainian_month_name = $ukrainian_months[$month_name] ?? '';
            $carts[] = [
                'label' => $day . ' ' . $ukrainian_month_name,
                'value' => 1,
            ];
        }

        $resultArray = $this->processCarts($carts);

        return $this->render('active-users-site-day', ['resultArray' => json_encode($resultArray)]);
    }
}
