<?php

namespace backend\widgets;

use common\models\shop\ActivePages;
use kartik\base\Widget;

class UserDevice extends Widget
{
    public function init()
    {

        parent::init();

    }

    public function run()
    {
        $mobil = [];
        $desktop = [];
        $no_detect = [];
        $count_devices = ActivePages::find()->select('other')->all();
        foreach ($count_devices as $count_device){
            if ($count_device->other == 'mobile'){
                $mobil[] = $count_device->other;
            }elseif ($count_device->other == 'desktop'){
                $desktop[] = $count_device->other;
            }else{
                $no_detect[] = 'no detect';
            }
        }
        $mobil = count($mobil);
        $desktop = count($desktop);
        $no_detect = count($no_detect);

        $res = [];
        $devices = ['mobile', 'desktop', 'no_detect'];
        foreach ($devices as $device){
            if ($device == 'mobile'){
                $name = 'Мобільний';
                $count = $mobil;
                $color = '#5dc728';
            }elseif ($device == 'desktop'){
                $name = 'Десктоп';
                $count = $desktop;
                $color = '#3377ff';
            }else{
                $name = 'Не визначений';
                $count = $no_detect;
                $color = '#e62e2e';
            }

            $res[] = [
                "label" => $name,
                "value" => $count,
                "color" => $color,
            ];
        }

        return $this->render('user-device', [
            'res' => json_encode($res),
            'mobil' => $mobil,
            'desktop' => $desktop,
            'no_detect' => $no_detect,
        ]);
    }
}
