<?php

namespace console\controllers;

use backend\models\IpBot;
use LisDev\Delivery\NovaPoshtaApi2;
use common\models\shop\ActivePages;
use common\models\NpWarehouses;
use backend\models\SearchWords;
use common\models\shop\Product;
use yii\console\Controller;
use common\models\NpCity;
use yii\helpers\Console;
use yii\db\Query;
use Yii;


class CronController extends Controller
{
    /**
     * Добавленрие отделений НП
     */
    public function actionWarehouses()
    {
        $key = Yii::$app->params['novaPostKey'];
        $np = new NovaPoshtaApi2(
            $key,
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


    /**
     *  Убрать ненужные ссылки
     */
    public function actionDeleteUnnecessaryLinks()
    {
        $limit = 300;

        self::removalDuplicateLinks($limit);
        self::removalUnknownLinks($limit);
        self::removalPageLinks($limit);
        self::removalSiteTransitionsLinks($limit);
        self::removalBotIp($limit);
        self::removalUrlNonExistent($limit);
        self::addSearchWord($limit);

    }

    protected function removalDuplicateLinks($limit)
    {
        $pages = ActivePages::find()
            ->select(['id', 'ip_user', 'url_page'])
            ->orderBy(['id' => SORT_DESC])
            ->limit($limit)
            ->asArray()
            ->all();

        $matchedIds = [];

        $k = 0;
        for ($i = 0; $i < count($pages) - 1; $i++) {
            $current = $pages[$i];
            $next = $pages[$i + 1];

            if ($current['ip_user'] === $next['ip_user'] && $current['url_page'] === $next['url_page']) {
                $matchedIds[] = $current['id'];
                if ($k == 0) {
                    Console::output("\n\t====================================================");
                    Console::output("\n\t 🔎 *** Убрать дубли ссылок ***");
                    $k++;
                }
                Console::output("\n ✔ Збіг: ID {$current['id']} та ID {$next['id']} (IP: {$current['ip_user']}, URL: {$current['url_page']})");
            }
        }
        if (count($matchedIds) != 0) {

            Console::output("\n 🔎 Збіги знайдено: " . count($matchedIds));

            $deleted = ActivePages::deleteAll(['id' => $matchedIds]);

            Console::output("\n 🗑️ Видалено записів: {$deleted}");
        }
    }

    protected function removalUnknownLinks($limit)
    {
        $urls = ActivePages::find()
            ->where(['client_from' => 'Не известно'])
            ->andWhere(['status_serv' => '200'])
            ->limit($limit)
            ->orderBy(['date_visit' => SORT_DESC])
            ->all();

        if ($urls) {
            Console::output("\n\t====================================================");
            Console::output("\n\t 🗑️ **** Убрать ссылки с неизвестным переходом ****");
            foreach ($urls as $url) {
                if ($url->delete()) {
                    Console::output("\n ❌ [IP: {$url->ip_user}] «{$url->url_page}»: Статус: {$url->status_serv}");
                }
            }
        }
    }

    protected function removalPageLinks($limit)
    {
        $urls = ActivePages::find()
            ->where(['like', 'url_page', '/page/'])
            ->andWhere(['status_serv' => '200'])
            ->limit($limit)
            ->orderBy(['date_visit' => SORT_DESC])
            ->all();

        if ($urls) {
            Console::output("\n\t====================================================");
            Console::output("\n\t 🗑️ **** Убрать ссылки пагинацыи ****");
            foreach ($urls as $url) {
                if ($url->delete()) {
                    Console::output("\n ❌ [IP: {$url->ip_user}] «{$url->url_page}»: Статус: {$url->status_serv}");
                }
            }
        }
    }

    protected function removalSiteTransitionsLinks($limit)
    {
        $host = Yii::$app->params['hostInfo'];

        $exclude = ['/search/', '/cart/', '/order/'];

        $urls = ActivePages::find()
            ->where(['like', 'client_from', $host . '%', false])
            ->andWhere(['not like', 'url_page', $exclude])
            ->andWhere(['status_serv' => '200'])
            ->orderBy(['date_visit' => SORT_DESC])
            ->limit($limit)
            ->all();

        if ($urls) {
            Console::output("\n\t====================================================");
            Console::output("\n\t 🗑️ **** Убрать ссылки перехода по сайту ****");
            foreach ($urls as $url) {
                if ($url->delete()) {
                    Console::output("\n ❌ [IP: {$url->ip_user}] «{$url->client_from}»: Статус: {$url->status_serv}");
                }
            }
        }
    }

    protected function addSearchWord($limit)
    {
        $searchUrl = ActivePages::find()
            ->where(['like', 'url_page', '/search/'])
            ->orderBy(['date_visit' => SORT_DESC])
            ->limit($limit)
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
                Console::output("\n\t====================================================");
                Console::output("\n\t **** Слова добавлены, ссылки удалены **** ");
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

    protected function removalBotIp($limit)
    {
        $exclude = ['/search/', '/cart/', '/order/'];

        $botIps = IpBot::find()->select('ip')->where(['blocking' => 1])->column();

        $usersIp = ActivePages::find()
            ->where(['status_serv' => '200'])
            ->andWhere(['not like', 'url_page', $exclude])
            ->limit($limit)
            ->orderBy(['date_visit' => SORT_DESC])
            ->asArray()
            ->all();

        $deleteId = [];
        foreach ($botIps as $botIp) {
            foreach ($usersIp as $userIp) {
                if (str_contains($userIp['ip_user'], $botIp)) {

                    $deleteId[] = $userIp['id'];
                }
            }

        }

        if (!empty($deleteId)) {
            ActivePages::deleteAll(['id' => $deleteId]);
        }
    }

    protected function removalUrlNonExistent($limit)
    {
        $badParts = [
            'wp-login',
            'check_user',
            'sprite',
            'well-known',
            'yii.js',
            'jquery.min.js',
            'extra_large',
        ];

        $links = ActivePages::find()
            ->where(['status_serv' => '404'])
            ->orderBy(['date_visit' => SORT_DESC])
            ->limit($limit)
            ->all();
        if ($links) {
            $i = 1;
            foreach ($links as $link) {
                foreach ($badParts as $bad) {
                    if (!empty($bad) && !empty($link->url_page)) {
                        if (str_contains($link->url_page, $bad)) {
                            if ($i === 1) {
                                Console::output("\n\t====================================================");
                                Console::output("\n\t 🗑️ **** Убрать не существующие ссылки ****");
                            }
                            $link->delete();
                            Console::output("\n Удалено запись: {$link->url_page} ");
                            $i++;
                            break;
                        }
                    }
                }
            }
        }
    }

}

