<?php

namespace console\controllers;

use backend\models\Report;
use backend\models\ReportItem;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\console\Controller;

class ReportController extends Controller
{
    /**
     * Добавление Excel файла отчета в базу
     */
    public function actionAddReport()
    {
        $filePath = 'E:/OSPanel/domains/agro/backend/runtime/reportItem.xlsx';
//            $filePath = Yii::getAlias('@backend/runtime/report.xlsx');

        // Проверка расширения файла
        $fileInfo = pathinfo($filePath);
        if (!isset($fileInfo['extension']) || strtolower($fileInfo['extension']) !== 'xlsx') {
            echo 'Invalid file extension: ' . $filePath;
            Yii::error('Invalid file extension: ' . $filePath, __METHOD__);
            return;
        }

        try {
            $spreadsheet = IOFactory::load($filePath);
            // Ваш код для обработки данных из файла
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            echo 'Error loading file: ', $e->getMessage();
        }

        if (file_exists($filePath)) {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();
//                unlink($filePath);
            $headers = array_shift($data);
            $resultArray = [];

            foreach ($data as $row) {
                $resultArray[] = array_combine($headers, $row);
            }

        } else {
            echo 'Файл не существует.';
        }

        foreach ($resultArray as $item) {
            $platform = $item['платформа'];
            if ($platform) {
                $order_id = Report::find()->select('id')->where(['platform' => $platform])->asArray()->one();
            }
            $model = new ReportItem();
            $model->order_id = $order_id['id'];
            $model->product_name = $item['Назва товару'];
            $model->price = $item['Ціна на клієнта, л(кг)/грн'];
            $model->unit = $item['Од.виміру'];
            $model->quantity = $item['К-ть'];
            $model->entry_price = $item['вхід АП з ПДВ, грн'];
            $model->platform_price = $item['списання з площадок'];
            $model->save(false);
        }
    }

    /**
     * Форматирование даты в базе
     */
    public function actionDateDeliveryReport()
    {
        $datesDelivery = Report::find()->select(['date_delivery', 'id'])->asArray()->all();

        foreach ($datesDelivery as $item) {
            if ($item['date_delivery']) {
                $date = $item['date_delivery'];
                $id = $item['id'];

                $dateParts = explode('/', $date);

                if (count($dateParts) == 3) {
                    // Форматируем дату в формат YYYY-MM-DD
                    $dateFormat = sprintf('%04d-%02d-%02d', $dateParts[2], $dateParts[0], $dateParts[1]);

                    $model = Report::find()->where(['id' => $id])->one();

                    $model->date_delivery = $dateFormat;

                    $model->save(false);

                } else {
                    echo "\t" . $date . " Не совпало количество! \n";
                }
            } else {
                echo "\t" . " Нет даты! \n";
            }
        }
    }

    /**
     * Форматирование Платформы в базе
     */
    public function actionPlatformOrderReport()
    {
        $symbol = 'м';
        $lengthPlatform = 20;
        $newItem = 'Prom';

        $dates = Report::find()->select(['platform', 'id'])->asArray()->all();

        foreach ($dates as $item) {
            if ($item['platform']) {
                $platform = $item['platform'];
                $id = $item['id'];

                $length = mb_strlen($platform, 'UTF-8');

                if ($length <= $lengthPlatform) {
                    $lastChar = mb_substr($platform, -1, 1, 'UTF-8');
                    if ($lastChar == $symbol) {

                        $model = Report::find()->where(['id' => $id])->one();

                        $model->platform = $newItem;

                        $model->save(false);

                    } else {
                        echo "\t" . " Последний символ не " . $symbol . " ! \n";
                    }
                } else {
                    echo "\t" . " Строка больше " . $lengthPlatform . " символов! \n";
                }

            } else {
                echo "\t" . " Нет платформы! \n";
            }
        }
    }

    /**
     * Форматирование Номера в базе
     */
    public function actionPhoneReport()
    {
        $i = 1;
        $symbol = '0';
        $lengthPlatform = 9;

        $dates = Report::find()->select(['tel_number', 'id'])->asArray()->all();

        foreach ($dates as $item) {
            if ($item['tel_number']) {
                $tel_number = $item['tel_number'];
                $id = $item['id'];

                $length = mb_strlen($tel_number, 'UTF-8');

                if ($length == $lengthPlatform) {

                    $tel_number = $symbol . $tel_number;

                    $countryCode = "+38";
                    $areaCode = substr($tel_number, 0, 3);
                    $firstPart = substr($tel_number, 3, 3);
                    $secondPart = substr($tel_number, 6);

                    $formattedNumber = sprintf("%s(%s)%s %s", $countryCode, $areaCode, $firstPart, $secondPart);

                    echo "\t" . $i . " Номер старый и форматированный  " . $tel_number . "  " . $formattedNumber . "\n";
                    $i++;


                    $model = Report::find()->where(['id' => $id])->one();

                    $model->tel_number = $formattedNumber;

                    $model->save(false);


                } else {
//                    echo "\t" . " Номер состоит не из 9 цифр  " . $tel_number . "\n";
                }

            } else {
//                echo "\t" . " Нет номера !!! \n";
            }
        }
    }

    /**
     * Проверка целостности данных в базе
     */
    public function actionValidatorsReport()
    {

        $ordersId = ReportItem::find()->select('order_id')->column();

        $uniqueArray = array_unique($ordersId);

        foreach ($ordersId as $item) {

            $order = Report::find()->where(['id' => $item])->one();
            if (!$order) {
                echo "\t" . " ID нет в таблице Report " . $item . " ! \n";
            } else {
                echo "\t" . " ID есть в таблице Report " . $item . " ! \n";
            }
        }
    }

    /**
     * Форматирование Тип оплаты в базе
     */
    public function actionTypePayment()
    {
        $i = 1;
        $word = 'нк';
        $newWord = 'Наложка карта У';

        $payments = Report::find()->select(['type_payment', 'id'])->asArray()->all();

        foreach ($payments as $item) {

            $id = $item['id'];
            $typePayment = $item['type_payment'];

            if ($typePayment) {
                if ($typePayment === $word) {
                    $model = Report::find()->where(['id' => $id])->one();
                    $model->type_payment = $newWord;
                    $model->save(false);
                    echo "\t" . $i . " Слово  " . $word . "  перезаписано словом  " . $newWord . " ! \n";
                    $i++;
                }
            }
        }
    }

    /**
     * Добавить Доставку НП если ТТН ХХХХ
     */
    public function actionAddDeliveryNewPost()
    {
        $i = 1;
        $ttn = '5900';
        $delivery = 'Нова Пошта';
        $orders = Report::find()->all();

        foreach ($orders as $order) {
            if ($order->ttn) {
                $firstFourChars = mb_substr($order->ttn, 0, 4);
                if ($firstFourChars == $ttn) {
                    if (!$order->delivery_service){
                        $order->delivery_service = $delivery;

                    if (!$order->save(true)) {
                        Yii::error("Order ID {$order->id} could not be saved.");
                    }
                        echo "\t" . $i . " Заказ № " . $order->id . " Записана служба доставки \n";
                        $i++;
                    }else{
                        echo "\t" . " Заказ № " . $order->id . " Cлужба доставки вже Записана !!!  \n";
                    }

                }else{
                    echo "\t" . " ТТН № " . $order->ttn . " Не соответствует условию! " . $firstFourChars. " не равно " . $ttn . "\n";
                }
            }else{
                echo "\t" . " Заказ № " . $order->id . " Не заполнен! \n";
            }
        }
    }
}