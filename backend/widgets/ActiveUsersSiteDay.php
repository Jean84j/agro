<?php

namespace backend\widgets;

use app\widgets\BaseWidgetBackend;
use common\models\shop\ActivePages;

class ActiveUsersSiteDay extends BaseWidgetBackend
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {

        $resultArray = $this->SiteDay();
        $resultArrayOld = $this->SiteDayOld();

        return $this->render('active-users-site-day', [
            'resultArray' => json_encode($resultArray),
            'resultArrayOld' => json_encode($resultArrayOld),
        ]);
    }

    protected function SiteDay(){
        $dateFrom = strtotime(date('Y-m-d', strtotime('-30 days'))); // 00:00:00 30 дней назад

        $users = ActivePages::find()
            ->select('date_visit')
            ->where(['>=', 'date_visit', $dateFrom])
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

        return $this->processCarts($carts);
    }

    protected function SiteDayOld(){
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

        return $this->processCarts($carts);
    }
}
