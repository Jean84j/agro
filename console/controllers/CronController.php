<?php

namespace console\controllers;

use backend\models\IpBot;
use backend\models\SearchWords;
use common\models\shop\ActivePages;
use common\models\shop\Product;
use yii\console\Controller;
use common\models\NpCity;
use common\models\NpWarehouses;
use LisDev\Delivery\NovaPoshtaApi2;
use yii\db\Query;
use yii\helpers\Console;


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
        if ($status == '-> ROBOT <-') {
            echo "\t $countIps\t\t $ip\t\t $status\t\t " . ($response['isp']) . "\n";
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

        $begin = true;
        $end = false;

        $cities = NpCity::find()
            ->select('ref')
            ->where(['city' => $begin])
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
                                $n++;
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
                    $model->city = $end;
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

    /**
     *  Добвить товарам количество просмотров
     */
    public function actionAddCountViewsProduct()
    {
        $rows = (new Query())
            ->select([
                'p.id',
                'COUNT(ap.id) as views'
            ])
            ->from(['p' => Product::tableName()])
            ->leftJoin(['ap' => ActivePages::tableName()], 'ap.url_page LIKE CONCAT("%", p.slug, "%")')
            ->groupBy('p.id')
            ->all();

        foreach ($rows as $row) {
            Product::updateAll(
                ['views' => $row['views']],
                ['id' => $row['id']]
            );
        }
    }

    /**
     *  Добвить слова с поиска
     */
    public function actionAddSearchWord()
    {
        $searchUrl = ActivePages::find()
            ->where(['like', 'url_page', '/search/'])
            ->all();
        if ($searchUrl) {
            $idUrl = [];
            $words = [];
            foreach ($searchUrl as $item) {
                $idUrl[] = $item->id;
                $query = parse_url($item->url_page, PHP_URL_QUERY);
                parse_str($query, $params);

                $q = trim($params['q'] ?? '');

                if (!empty($q) && mb_strlen($q) >= 3) {
                    $words[] = $q;
                }
            }

            if ($words) {
                foreach ($words as $word) {
                    $searchWords = SearchWords::find()->where(['word' => $word])->one();

                    if ($searchWords) {
                        $searchWords->counts_query = $searchWords->counts_query + 1;
                        $searchWords->save();
                    } else {
                        $model = new SearchWords();
                        $model->word = $word;
                        $model->counts_query = 1;
                        $model->save();

                        Console::output("\n🔎 --> : " . ' ' . $word);
                    }
                }

                if ($idUrl) {
                    ActivePages::deleteAll(['id' => $idUrl]);
                }
            }
        }
    }

    /**
     *  Убрать лишние ссылки
     */
    public function actionDeleteUnknownTransitions()
    {
        $urls = ActivePages::find()
            ->where(['client_from' => 'Не известно'])
            ->andWhere(['status_serv' => '200'])
            ->limit(1000)
            ->orderBy(['date_visit' => SORT_DESC])
            ->all();

        if ($urls) {
            Console::output("\t 🗑️ *** Убрать лишние ссылки ***");
            foreach ($urls as $url) {
                if ($url->delete()) {
                    Console::output("\n ❌ [ID: {$url->id}] «{$url->url_page}»: Статус: {$url->status_serv}");
                }
            }
        }
    }

    /**
     *  Убрать дубли ссылок
     */
    public function actionDeleteDuplicateUrl()
    {
        $pages = ActivePages::find()
            ->select(['id', 'ip_user', 'url_page'])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1000)
            ->asArray()
            ->all();

        $matchedIds = [];

        for ($i = 0; $i < count($pages) - 1; $i++) {
            $current = $pages[$i];
            $next = $pages[$i + 1];

            if ($current['ip_user'] === $next['ip_user'] && $current['url_page'] === $next['url_page']) {
                $matchedIds[] = $current['id'];

                Console::output("✔ Збіг: ID {$current['id']} та ID {$next['id']} (IP: {$current['ip_user']}, URL: {$current['url_page']})");
            }
        }
        if (count($matchedIds) != 0) {
            Console::output("\t🔎 *** Убрать дубли ссылок ***");
            Console::output("\n🔎 Збіги знайдено: " . count($matchedIds));

            $deleted = ActivePages::deleteAll(['id' => $matchedIds]);

            Console::output("\n🗑️ Видалено записів: {$deleted}");
        }
    }

    /**
     *  Убрать дубликаты поисковых слов
     */
    public function actionDeleteDuplicateWord()
    {
        $words = SearchWords::find()->asArray()->all();

        usort($words, fn($a, $b) => mb_strlen($b['word']) - mb_strlen($a['word']));

        $result = [];

        foreach ($words as $item) {
            $found = false;

            foreach ($result as $r) {
                if (mb_strpos($r['word'], $item['word']) !== false) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $result[] = $item;
            }
        }

        // оставляем только нужные ID
        $idsToKeep = array_column($result, 'id');

        // удаляем всё лишнее
        SearchWords::deleteAll(['not in', 'id', $idsToKeep]);
        if ((count($words) - count($idsToKeep) != 0)) {
            $count = count($words) - count($idsToKeep);
            Console::output("\t🗑️ *** Убрать дубликаты поисковых слов ***");
            Console::output("\n");
            Console::output("\n Удалено слов: {$count} ");

        }
    }

}

