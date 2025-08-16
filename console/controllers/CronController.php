<?php

namespace console\controllers;

use common\models\IpBot;
use common\models\shop\ActivePages;
use yii\console\Controller;
use common\models\NpCity;
use common\models\NpWarehouses;
use LisDev\Delivery\NovaPoshtaApi2;
use yii\db\Expression;

class CronController extends Controller
{
    /**
     * Cron задача для удаления Ip роботов последние 40 записей каждые 30 минут
     */
    public function actionDetectIpRobots()
    {
        $this->processIpRobots(40);
    }

    /**
     * Cron задача для удаления Ip роботов вся база раз в сутки
     */
    public function actionDetectIpRobotsAll()
    {
        $this->processIpRobots();
    }

    /**
     * Общая обработка IP роботов
     *
     * @param int|null $limit Лимит записей для обработки, если null - обрабатывается вся база
     */
    private function processIpRobots(?int $limit = null)
    {
        $query = ActivePages::find()
            ->select(['ip_user', 'date_visit'])
            ->orderBy('date_visit DESC');

        if ($limit) {
            $query->limit($limit);
        }

        $ips = $query->asArray()->all();

        // Уникальные IP
        $ips = array_unique(array_map('serialize', array_column($ips, 'ip_user')));
        $ips = array_map('unserialize', $ips);

        $robotProviders = IpBot::find()->select('isp')->distinct()->column();
        $robotIp = IpBot::find()->select('ip')->distinct()->column();
        $ipDelete = [];

        $countIps = count($ips);

        foreach ($ips as $ip) {
            $this->processSingleIp($ip, $robotProviders, $robotIp, $ipDelete, $countIps);
            sleep(2); // Пауза между запросами
            $countIps--;
        }

        if ($ipDelete) {
            echo "=======================================\n";
            $this->getIpDelete($ipDelete);
            echo "=======================================\n";
        }
    }

    /**
     * Обработка одного IP
     *
     * @param string $ip IP-адрес пользователя
     * @param array $robotProviders Список провайдеров роботов
     * @param array $robotIp Список IP роботов
     * @param array &$ipDelete Массив IP для удаления
     * @param int $countIps Количество оставшихся IP для обработки
     */
    private function processSingleIp($ip, $robotProviders, $robotIp, &$ipDelete, $countIps)
    {
        $url = "http://ip-api.com/json/{$ip}";
        $response = $this->getIpInfoFromApi($url);

        if ($response && $response['status'] === 'success') {
            $isRobot = $this->checkIfRobot($ip, $response, $robotProviders, $robotIp, $ipDelete);

            if (!$isRobot) {
                $this->outputIpInfo($ip, $response, $countIps, false);
            } else {
                $this->outputIpInfo($ip, $response, $countIps, true);
            }
        } else {
            echo "$ip: Error retrieving information.\n";
        }
    }

    /**
     * Проверка, является ли IP роботом
     *
     * @param string $ip IP-адрес
     * @param array $response Ответ от API
     * @param array $robotProviders Список провайдеров роботов
     * @param array $robotIp Список IP роботов
     * @param array &$ipDelete Массив IP для удаления
     * @return bool Возвращает true, если IP является роботом
     */
    private function checkIfRobot($ip, $response, $robotProviders, $robotIp, &$ipDelete)
    {
        foreach ($robotProviders as $provider) {
            if (strtolower($response['isp']) === strtolower($provider)) {

                if (!in_array($ip, $robotIp)) {
                    $this->saveRobotIp($ip, $response['isp']);
                }

                $ipDelete[] = $ip;
                return true;
            }
        }
        return false;
    }

    /**
     * Сохранение информации о роботе
     *
     * @param string $ip IP-адрес
     * @param string|null $isp Провайдер
     */
    private function saveRobotIp($ip, $isp = null)
    {
        $model = new IpBot();
        $model->ip = $ip;
        $model->isp = $isp ?: 'Not information';
        $model->save();
    }

    /**
     * Вывод информации об IP
     *
     * @param string $ip IP-адрес
     * @param array $response Ответ от API
     * @param int $countIps Количество оставшихся IP
     * @param bool $isRobot Является ли IP роботом
     */
         private function outputIpInfo($ip, $response, $countIps, $isRobot)
    {
        $status = $isRobot ? "-> ROBOT <-" : "not robot";
        
        $countIps = str_pad($countIps, 6, ' ', STR_PAD_LEFT);
        $ip = str_pad($ip, 20, ' ', STR_PAD_RIGHT);
        $status = str_pad($status, 20, ' ', STR_PAD_RIGHT);

            echo "\t $countIps\t\t $ip\t\t $status\t\t " . ($response['isp']) . "\n";

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
                echo "\t{$ip->ip_user}\tRemoved from database\n";
            } else {
                echo "\t{$ip->ip_user}\tFailed to delete from database\n";
            }
        }
    }


    /**
     * Обновление отделений Новой Почты
     */
    const KEY = 'f1c1e7b2520a9fa092bb1afa0e7bc514';

    /**
     * Добавленрие отделений НП
     */
    public function actionWarehouses()
    {
        $np = new NovaPoshtaApi2(
            self::KEY,
            'ua', // Язык возвращаемых данных: ru (default) | ua | en
            FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
            'file_get_content' // Используемый механизм запроса: curl (default) | file_get_content
        );

        $cities = NpCity::find()
            ->select('ref')
            ->where(['city' => true])
            ->limit(50)
            ->column();

        if ($cities) {
            $i = 1;
            $n = 1;
            foreach ($cities as $city) {
                $nameCity = NpCity::find()->where(['ref' => $city])->one();
                echo "\t" . "|#----->> " . '' . " | " . $nameCity->description . "\n";
                $warehouses = $np->getWarehouses($city);
                if (!empty($warehouses)) {
                    if ($warehouses['data'] != null) {
                        foreach ($warehouses['data'] as $warehouse) {
                            $model = NpWarehouses::find()->where(['ref' => $warehouse['Ref']])->one();
                            if (!$model) {
                                $warehouses_db = new NpWarehouses();
                                $warehouses_db->description = $warehouse['Description'];
                                $warehouses_db->ref = $warehouse['Ref'];
                                $warehouses_db->Number = $warehouse['Number'];
                                $warehouses_db->cityRef = $warehouse['CityRef'];
                                $warehouses_db->shortAddress = $warehouse['ShortAddress'];
                                if ($warehouses_db->save(false)) {
                                    echo "\t" . "|# " . $i . " | " . $warehouses_db->description . "\n";
                                    echo "\r+--------------------------------------------------------------------------------------------------------+\n";
                                    $i++;
                                } else {
                                    print_r($warehouses_db->errors);
                                }
                            } else {
//                                echo "\t" . "|- " . $n . " | " . $model->description . " Сущесвует\n";
//                                echo "\r+--------------------------------------------------------------------------------------------------------+\n";
//                                $n++;
                            }
                        }
                    }
                } else {
                    echo PHP_EOL . 'error warehouses' . PHP_EOL;
                    print_r($warehouses);
                    echo PHP_EOL . 'error city' . PHP_EOL;
                    print_r($city);
                }
            }

            foreach ($cities as $ref) {
                $model = NpCity::find()->where(['ref' => $ref])->one();
                if ($model) {
                    $model->city = false;
                    $model->save();
                } else {
                    echo "\t" . "|#----->> " . '' . " | *** Город не найден *** \n";
                }
            }

            echo "\n\t" . "|#----->> " . '' . " | *** END *** \n";
        } else {
            echo "\n\t" . "|#----->> " . '' . " | *** Города не найдены *** \n";
        }
    }
}

