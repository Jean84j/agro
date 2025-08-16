<?php

namespace console\controllers;

use common\models\shop\ActivePages;
use yii\console\Controller;
use Yii;

class DevicesController extends Controller
{
    /**
     * Добавление девайса в базу в поле other
     */
    public function actionDeviceDetect()
    {
        // mobile
//        $device = 'Android';

//        $device = 'iPhone OS 16_5';
//        $device = 'iPhone OS 14_8_1';


        //desktop
//        $device = 'Windows NT';

//        $device = 'Mac OS X 10_15_6';
        $device = 'Linux x86_64';


        $agents = ActivePages::find()->all();
        foreach ($agents as $agent){
        if ($agent->other === null){
            if (strpos($agent->user_agent, $device) !== false){
//                $agent->other = 'mobile';
                $agent->other = 'desktop';
                $agent->save();
            }
        }
        
        }
    }
    
      public function actionDetectRobotsIp()
    {
        $ips = ActivePages::find()
            ->select(['ip_user', 'date_visit'])
            ->orderBy('date_visit DESC')
            ->limit(100)
            ->asArray()
            ->all();

        $ips = array_map(function($item) {
            unset($item['date_visit']);
            return $item;
        }, $ips);

        $ips = array_unique(array_map('serialize', $ips));
        $ips = array_map('unserialize', array_values($ips));

        $countIps = count($ips);
        $robotProviders = [
            'google', 'hetzner', 'huawei', 'digitalocean', 'shenzhen',
            'amazon', 'microsoft', 'oracle', 'alibaba', 'tencent', 'OPHL'
        ];
        $filePath = Yii::getAlias('@frontend/runtime/robots_control.txt');
        $i = 1;
        $ipDelete = [];

        foreach ($ips as $ip) {
            $ip = $ip['ip_user'];
            $url = "http://ip-api.com/json/{$ip}";
            $response = $this->getIpInfoFromApi($url);

            if ($response && $response['status'] === 'success') {
                $org = strtolower($response['isp']);
                $isRobot = false;

                foreach ($robotProviders as $provider) {
                    if (str_contains($org, $provider)) {
                        $isRobot = true;
                        echo "$countIps\t\033[0;31m$ip\tRobot\t{$response['isp']}\033[0m\n";
                        $logEntry = "'$ip',\n";
                        file_put_contents($filePath, $logEntry, FILE_APPEND);
                        $ipDelete[] = $ip;
                        $i++;
                        break;
                    }
                }

                if (!$isRobot) {
                    echo "$countIps\t\033[0;32m$ip\tNot Robot.\t{$response['isp']}\033[0m\n";
                }
            } else {
                echo "$ip: Error retrieving information.\n";
            }

            sleep(2);
            $countIps--;
        }
        
        if ($ipDelete) {
            echo "=================================================================\n";
            $this->getIpDelete($ipDelete);
        }
    }
    
    /**
     * Метод для отправки запроса к API и получения данных
     */
    private function getIpInfoFromApi($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        return json_decode($output, true);
    }
    
    /**
     * Метод для удаления Ip из базы данных
     */
    private function getIpDelete($ipDelete)
    {
        $ips = ActivePages::find()->where(['ip_user' => $ipDelete])->all();
        foreach ($ips as $ip) {
            if ($ip->delete()) {
                echo "\t\033[0;31m{$ip->ip_user}\tУдален из базы данных\033[0m\n";
            } else {
                echo "\t\033[0;33m{$ip->ip_user}\tНе удалось удалить из базы данных\033[0m\n";
            }
        }
    }
}