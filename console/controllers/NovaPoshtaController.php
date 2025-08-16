<?php

namespace console\controllers;

use common\models\NpAreas;
use common\models\NpCity;
use common\models\NpWarehouses;
use Yii;
use yii\console\Controller;
use LisDev\Delivery\NovaPoshtaApi2;

class NovaPoshtaController extends Controller
{
    const KEY = 'f1c1e7b2520a9fa092bb1afa0e7bc514';

    /**
     * Получить области
     */
    public function actionAreas()
    {
        $np = new NovaPoshtaApi2(
            self::KEY,
            'ua', // Язык возвращаемых данных: ru (default) | ua | en
            FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
            'file_get_content' // Используемый механизм запроса: curl (defalut) | file_get_content
        );

        $areas = $np->getAreas();
        $i = 1;
        $n = 1;
        foreach ($areas['data'] as $area) {
            $model = NpAreas::find()->where(['Ref' => $area['Ref']])->one();
            if (!$model) {
                $new_model = new NpAreas();
                $new_model->ref = $area['Ref'];
                $new_model->areasCenter = $area['AreasCenter'];
                $new_model->description = $area['Description'];
                if ($new_model->save()) {
                    echo "|+ " . $i . " | " . $new_model->description . "\n";
                    echo "\r+---+------------------------------------------------------------------------------+\n";
                } else {
                    print_r($new_model->errors);
                }
                $i++;
            } else {
                echo "|- " . $n . " | " . $model->description . " Сущесвует\n";
                echo "\r+---+------------------------------------------------------------------------------+\n";
                $n++;
            }
        }
    }

    /**
     * Получить города у областей
     */
    public function actionCities()
    {
        $np = new NovaPoshtaApi2(
            self::KEY,
            'ru', // Язык возвращаемых данных: ru (default) | ua | en
            FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
            'file_get_content' // Используемый механизм запроса: curl (defalut) | file_get_content
        );

        $cities = $np->getCities();
        $i = 1;
        $n = 1;
        foreach ($cities['data'] as $array) {
            $model = NpCity::find()->where(['Ref' => $array['Ref']])->one();
            if (!$model) {
                $city = new NpCity();
                $city->description = $array['Description'];
                $city->ref = $array['Ref'];
                $city->area = $array['Area'];
                $city->cityID = $array['CityID'];
                if ($city->save()) {
                    echo "|+ " . $i . " | " . $city->description . "\n";
                    echo "\r+---+------------------------------------------------------------------------------+\n";
                } else {
                    print_r($city->errors);
                }
                $i++;
            } else {
                echo "|- " . $n . " | " . $model->description . " Сущесвует\n";
                echo "\r+---+------------------------------------------------------------------------------+\n";
                $n++;
            }
        }
    }

    /**
     * Добавленрие отделений НП
     */
    public function actionWarehouses()
    {
        $np = new NovaPoshtaApi2(
            self::KEY,
            'ua', // Язык возвращаемых данных: ru (default) | ua | en
            FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
            'file_get_content' // Используемый механизм запроса: curl (defalut) | file_get_content
        );

        $cities = NpCity::find()->select('ref')->column();
        if ($cities) {
            $i = 1;
            $n = 1;
            $j = 1;
            foreach ($cities as $city) {
                if ($j >= 1) {
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
                                        echo "\033[0;31m" . "|# " . $i . " | " . $warehouses_db->description . "\n";
                                        echo "\r+--------------------------------------------------------------------------------------------------------+\n";
                                        $i++;
                                    } else {
                                        print_r($warehouses_db->errors);
                                    }
                                } else {
                                    echo "\033[0;32m" . "|- " . $n . " | " . $model->description . " Сущесвует\n";
                                    echo "\r+--------------------------------------------------------------------------------------------------------+\n";
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
                $j++;
            }
        }
    }

    /**
     * Города без отделений НП
     */
    public function actionNoCitiesWarehouses()
    {
        $np = new NovaPoshtaApi2(
            self::KEY,
            'ua', // Язык возвращаемых данных: ru (default) | ua | en
            FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
            'file_get_content' // Используемый механизм запроса: curl (defalut) | file_get_content
        );

        $cities = NpCity::find()->all();
        $i = 1;
        foreach ($cities as $city) {
//            $warehouses = $np->getWarehouses($city->ref);
            $warehouses = $np->getWarehouses('38861002-de39-11ea-80fb-b8830365bd04');
            dd($warehouses);
            if ($warehouses['data'] == null) {
                echo "\033[0;32m" . "|- " . $i . " | " . $city->ref . '<>' . $city->description . " Без отделений\n";
                echo "\r+--------------------------------------------------------------------------------------------------------+\n";
                $i++;
            }
        }
    }


    /**
     * Очистить талицу городов Новая Почта
     */
    public function actionTruncateCities()
    {
        $rm_cities = Yii::$app->db->createCommand()->truncateTable('npCity')->execute();
        if ($rm_cities) {
            echo "\n очищено таблицу городов {`npCities`} НП \n";
        }
    }

    /**
     * Очистить талицу отделений Новая Почта
     */
    public function actionTruncateWarehouses()
    {
        $rm_warehouses = Yii::$app->db->createCommand()->truncateTable('npWarehouses')->execute();
        if ($rm_warehouses) {
            echo "\n очищено таблицу отделения {`npWarehouses`} НП \n";
        }
    }

    /**
     * Очистить талицу областей Новая Почта
     */
    public function actionTruncateAreas()
    {
        $rm_warehouses = Yii::$app->db->createCommand()->truncateTable('npAreas')->execute();
        if ($rm_warehouses) {
            echo "\n очищено таблицу области {`npAreas`} НП \n";
        }
    }
}


