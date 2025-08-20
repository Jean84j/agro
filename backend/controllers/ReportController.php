<?php

namespace backend\controllers;

use common\models\Report;
use backend\models\search\ReportSearch;
use common\models\ReportItem;
use common\models\ReportReminder;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use yii\web\Response;

/**
 * ReportController implements the CRUD actions for Report model.
 */
class ReportController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Report models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index-grid', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Report model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $events = ReportReminder::find()->where(['report_id' => $id])->andWhere(['status' => 1])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'events' => $events,
        ]);
    }

    /**
     * Creates a new Report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Report();

        $model->date_order = date('Y-m-d');

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save(true) && $model->validate()) {

                Yii::$app->session->setFlash('info', ' Заявку створено, Додайте товари!');

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Report model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', ' Інформація про замовлення оновлена!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Report model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $products = ReportItem::find()->where(['order_id' => $model->id])->all();
        foreach ($products as $product) {

            $product->delete();
        }
        $model->delete();
        Yii::$app->session->setFlash('warning', ' Замовлення видалено!!!');
        return $this->redirect(['index']);
    }

    public function actionAddReportItem()
    {
        $model = new ReportItem();
        if (Yii::$app->request->isGet) {

            $report_item = Yii::$app->request->get();

            $model->order_id = $report_item['reportId'];
            $model->product_name = trim($report_item['productName']);
            $model->quantity = $report_item['quantity'];
            $model->price = $report_item['price'];
            $model->package = $report_item['package'];
            $model->entry_price = $report_item['in_price'];
            $model->discount = $report_item['discount_price'];
            $model->platform_price = $report_item['platform_price'];
            $model->kurs = $report_item['kurs'];
            $model->save(true);

            Yii::$app->session->setFlash('success', ' Товар додано в карточку!');

        }
        return $this->redirect(['view', 'id' => $report_item['reportId']]);
    }

    public function actionUpdateReportItem()
    {
        if (Yii::$app->request->isGet) {

            $report_item = Yii::$app->request->get();
            $item = ReportItem::find()->where(['id' => $report_item['reportItemId']])->one();

            $item->quantity = $report_item['quantity'];
            $item->price = $report_item['price'];
            $item->package = $report_item['package'];
            $item->entry_price = $report_item['in_price'];
            $item->discount = $report_item['discount_price'];
            $item->platform_price = $report_item['platform_price'];
            $item->kurs = $report_item['kurs'];
            $item->save(true);

            Yii::$app->session->setFlash('success', ' Інформація про товар оновлена!');

            return $this->redirect(['view', 'id' => $item->order_id]);
        }
        return $this->redirect('index');
    }

    public function actionDeleteReportItem($id)
    {
        $reportItem = ReportItem::findOne($id);
        if ($reportItem) {
            $reportItem->delete();

            Yii::$app->session->setFlash('warning', ' Товар видалено!');

            return $this->redirect(['view', 'id' => $reportItem->order_id]);
        } else {
            throw new NotFoundHttpException('Товар не найден');
        }
    }


    public function actionAddReportReminder()
    {
        $model = new ReportReminder();
        if (Yii::$app->request->isGet) {

            $reminder = Yii::$app->request->get();

            $model->report_id = $reminder['reportId'];

            $model->date = strtotime($reminder['eventDate']);
            $model->event = $reminder['eventName'];
            $model->status = 1;
            $model->comment = $reminder['eventComment'];

            $model->save(true);


            Yii::$app->session->setFlash('success', ' Нагадування додано!');

        }
        return $this->redirect(['view', 'id' => $reminder['reportId']]);
    }


    public function actionPeriodReport()
    {
        $periodStart = Report::find()->min('date_order');
        $periodEnd = Report::find()->max('date_order');

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['periodStart'])) {
            $periodStart = $_GET['periodStart'];
            $periodEnd = $_GET['periodEnd'];
        }

        Yii::$app->session->set('periodStart', $periodStart);
        Yii::$app->session->set('periodEnd', $periodEnd);

        $bigQty = $bigSum = $bigAllQty = $bigAllSum = $bigDiscount = $bigDelivery = $bigAllDelivery = $bigPlatform = [];
        $smallQty = $smallSum = $smallAllQty = $smallAllSum = $smallDiscount = $smallDelivery = $smallAllDelivery = $smallPlatform = [];
        $bigAllReturnQty = $smallAllReturnQty = $bigIncomingPriceSum = $smallIncomingPriceSum = [];
        $noPackage = [];
        $i = 0;

        $models = Report::find()
            ->select(['id', 'platform', 'date_delivery', 'price_delivery', 'order_status_id', 'order_pay_ment_id'])
            ->where(['between', 'date_order', $periodStart, $periodEnd])
            ->andWhere(['<>', 'order_status_id', 'Відміна'])
            ->all();

        foreach ($models as $model) {

            $package = $model->getPackage($model->id);
            $isPaid = $model->order_pay_ment_id == 'Оплачено';
            $isReturn = $model->order_status_id == 'Повернення' || $model->order_pay_ment_id == 'Повернення';
            $totalSum = $model->getTotalSumPeriod($model->id);
            $incomingPriceSum = $model->getItemsIncomingPrice($model->id);
            $discount = $model->getItemsDiscount($model->id);
            $platformPrice = $model->getItemsPlatformPrice($model->id);
            $priceDelivery = $model->price_delivery;

            if ($isPaid || $isReturn) {
                switch ($package) {
                    case 'Фермерська':
                        if ($isPaid) {
                            $bigQty[] = $package;
                            $bigSum[] = $totalSum;
                            $bigIncomingPriceSum[] = $incomingPriceSum;
                            $bigDiscount[] = $discount;
                            $bigPlatform[] = $platformPrice;
                            $bigDelivery[] = $priceDelivery;
                        } else {
                            $bigAllReturnQty[] = 'BIG';
                            $bigDelivery[] = $priceDelivery;
                        }
                        break;
                    case 'Дрібна':
                        if ($isPaid) {
                            $smallQty[] = $package;
                            $smallSum[] = $totalSum;
                            $smallIncomingPriceSum[] = $incomingPriceSum;
                            $smallDiscount[] = $discount;
                            $smallPlatform[] = $platformPrice;
                            $smallDelivery[] = $priceDelivery;
                        } else {
                            $smallAllReturnQty[] = 'SMALL';
                            $smallDelivery[] = $priceDelivery;
                        }
                        break;
                    case 'Фермерська + Дрібна':
                        if ($isPaid) {
                            $bigQty[] = 'BIG';
                            $smallQty[] = 'SMALL';
                            $smallDelivery[] = $priceDelivery;
                            $items = ReportItem::find()->where(['order_id' => $model->id])->asArray()->all();
                            foreach ($items as $item) {
                                $quantity = $item['quantity'];
                                if ($item['package'] == 'BIG') {
                                    $bigSum[] = $item['price'] * $quantity;
                                    $bigIncomingPriceSum[] = $item['entry_price'] * $quantity;
                                    $bigDiscount[] = $item['discount'];
                                    $bigPlatform[] = $item['platform_price'];
                                } else {
                                    $smallSum[] = $item['price'] * $quantity;
                                    $smallIncomingPriceSum[] = $item['entry_price'] * $quantity;
                                    $smallDiscount[] = $item['discount'];
                                    $smallPlatform[] = $item['platform_price'];
                                }
                            }
                        } else {
                            $bigAllReturnQty[] = 'BIG';
                            $smallAllReturnQty[] = 'SMALL';
                            $smallDelivery[] = $priceDelivery;
                        }
                        break;
                    default:
                        $noPackage[] = 'Не визначено';
                        break;
                }
            } else {
                $i++;
            }

            switch ($package) {
                case 'Фермерська':
                    $bigAllQty[] = $package;
                    $bigAllSum[] = $totalSum;
                    $bigAllDelivery[] = $priceDelivery;
                    break;
                case 'Дрібна':
                    $smallAllQty[] = $package;
                    $smallAllSum[] = $totalSum;
                    $smallAllDelivery[] = $priceDelivery;
                    break;
                case 'Фермерська + Дрібна':
                    $bigAllQty[] = 'BIG';
                    $smallAllQty[] = 'SMALL';
                    $bigAllDelivery[] = $priceDelivery;
                    $items = ReportItem::find()->where(['order_id' => $model->id])->asArray()->all();
                    foreach ($items as $item) {
                        $quantity = $item['quantity'];
                        if ($item['package'] == 'BIG') {
                            $bigAllSum[] = $item['price'] * $quantity;
                        } else {
                            $smallAllSum[] = $item['price'] * $quantity;
                        }
                    }
                    break;
                default:
                    $noPackage[] = 'Не визначено';
                    break;
            }
        }

        $bigAllDelivery = array_sum($bigAllDelivery);
        $smallAllDelivery = array_sum($smallAllDelivery);
        $bigQtyCount = count($bigQty);
        $bigSumTotal = array_sum($bigSum);
        $smallQtyCount = count($smallQty);
        $smallSumTotal = array_sum($smallSum);
        $bigAllQtyCount = count($bigAllQty);
        $bigAllSumTotal = array_sum($bigAllSum);
        $smallAllQtyCount = count($smallAllQty);
        $smallAllSumTotal = array_sum($smallAllSum);
        $bigDiscountTotal = array_sum($bigDiscount);
        $bigDeliveryTotal = array_sum($bigDelivery);
        $bigPlatformTotal = array_sum($bigPlatform);
        $smallDiscountTotal = array_sum($smallDiscount);
        $smallDeliveryTotal = array_sum($smallDelivery);
        $smallPlatformTotal = array_sum($smallPlatform);
        $bigAllReturnQtyCount = count($bigAllReturnQty);
        $smallAllReturnQtyCount = count($smallAllReturnQty);
        $bigIncomingPriceSumTotal = array_sum($bigIncomingPriceSum);
        $smallIncomingPriceSumTotal = array_sum($smallIncomingPriceSum);

        return $this->render('period-report', [
            'model' => $models,
            'bigAllDelivery' => $bigAllDelivery,
            'smallAllDelivery' => $smallAllDelivery,
            'bigQty' => $bigQtyCount,
            'bigSum' => $bigSumTotal,
            'smallQty' => $smallQtyCount,
            'smallSum' => $smallSumTotal,
            'periodEnd' => $periodEnd,
            'bigAllQty' => $bigAllQtyCount,
            'bigAllSum' => $bigAllSumTotal,
            'periodStart' => $periodStart,
            'smallAllQty' => $smallAllQtyCount,
            'smallAllSum' => $smallAllSumTotal,
            'bigDiscount' => $bigDiscountTotal,
            'bigDelivery' => $bigDeliveryTotal,
            'bigPlatform' => $bigPlatformTotal,
            'smallDiscount' => $smallDiscountTotal,
            'smallDelivery' => $smallDeliveryTotal,
            'smallPlatform' => $smallPlatformTotal,
            'bigAllReturnQty' => $bigAllReturnQtyCount,
            'smallAllReturnQty' => $smallAllReturnQtyCount,
            'bigIncomingPriceSum' => $bigIncomingPriceSumTotal,
            'smallIncomingPriceSum' => $smallIncomingPriceSumTotal,
        ]);
    }

    public function actionPromReport()
    {
        $periodStart = Report::find()->min('date_order');
        $periodEnd = Report::find()->max('date_order');

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['periodStart'])) {
            $periodStart = $_GET['periodStart'];
            $periodEnd = $_GET['periodEnd'];
        }

        $bigQty = $bigSum = $bigDiscount = $bigDelivery = $bigPlatform = [];
        $smallQty = $smallSum = $smallDiscount = $smallDelivery = $smallPlatform = [];
        $bigIncomingPriceSum = $smallIncomingPriceSum = [];
        $noPackage = [];

        $models = Report::find()
            ->select(['id', 'platform', 'date_delivery', 'price_delivery', 'order_status_id', 'order_pay_ment_id'])
            ->where(['between', 'date_order', $periodStart, $periodEnd])
            ->andWhere(['platform' => 'Prom'])
            ->all();

        foreach ($models as $model) {
            $package = $model->getPackage($model->id);
            $totalSum = $model->getTotalSumPeriod($model->id);
            $incomingPriceSum = $model->getItemsIncomingPrice($model->id);
            $discount = $model->getItemsDiscount($model->id);
            $platformPrice = $model->getItemsPlatformPrice($model->id);
            $priceDelivery = $model->price_delivery;

            switch ($package) {
                case 'Фермерська':
                    $bigQty[] = $package;
                    $bigSum[] = $totalSum;
                    $bigIncomingPriceSum[] = $incomingPriceSum;
                    $bigDiscount[] = $discount;
                    $bigPlatform[] = $platformPrice;
                    $bigDelivery[] = $priceDelivery;
                    break;
                case 'Дрібна':
                    $smallQty[] = $package;
                    $smallSum[] = $totalSum;
                    $smallIncomingPriceSum[] = $incomingPriceSum;
                    $smallDiscount[] = $discount;
                    $smallPlatform[] = $platformPrice;
                    $smallDelivery[] = $priceDelivery;
                    break;
                case 'Фермерська + Дрібна':
                    $bigQty[] = 'BIG';
                    $smallQty[] = 'SMALL';
                    $smallDelivery[] = $priceDelivery;
                    $items = ReportItem::find()->where(['order_id' => $model->id])->asArray()->all();
                    foreach ($items as $item) {
                        $quantity = $item['quantity'];
                        if ($item['package'] == 'BIG') {
                            $bigSum[] = $item['price'] * $quantity;
                            $bigIncomingPriceSum[] = $item['entry_price'] * $quantity;
                            $bigDiscount[] = $item['discount'];
                            $bigPlatform[] = $item['platform_price'];
                        } else {
                            $smallSum[] = $item['price'] * $quantity;
                            $smallIncomingPriceSum[] = $item['entry_price'] * $quantity;
                            $smallDiscount[] = $item['discount'];
                            $smallPlatform[] = $item['platform_price'];
                        }
                    }
                    break;
                default:
                    $noPackage[] = 'Не визначено';
                    break;
            }
        }

        $bigQtyCount = count($bigQty);
        $bigSumTotal = array_sum($bigSum);
        $smallQtyCount = count($smallQty);
        $smallSumTotal = array_sum($smallSum);
        $bigDiscountTotal = array_sum($bigDiscount);
        $bigDeliveryTotal = array_sum($bigDelivery);
        $bigPlatformTotal = array_sum($bigPlatform);
        $smallDiscountTotal = array_sum($smallDiscount);
        $smallDeliveryTotal = array_sum($smallDelivery);
        $smallPlatformTotal = array_sum($smallPlatform);
        $bigIncomingPriceSumTotal = array_sum($bigIncomingPriceSum);
        $smallIncomingPriceSumTotal = array_sum($smallIncomingPriceSum);

        return $this->render('prom-report', [
            'model' => $models,
            'bigQty' => $bigQtyCount,
            'bigSum' => $bigSumTotal,
            'periodEnd' => $periodEnd,
            'smallQty' => $smallQtyCount,
            'smallSum' => $smallSumTotal,
            'periodStart' => $periodStart,
            'bigDiscount' => $bigDiscountTotal,
            'bigDelivery' => $bigDeliveryTotal,
            'bigPlatform' => $bigPlatformTotal,
            'smallDiscount' => $smallDiscountTotal,
            'smallDelivery' => $smallDeliveryTotal,
            'smallPlatform' => $smallPlatformTotal,
            'bigIncomingPriceSum' => $bigIncomingPriceSumTotal,
            'smallIncomingPriceSum' => $smallIncomingPriceSumTotal,
        ]);
    }

    public function actionAdvertisingReport()
    {
        $periodStart = Report::find()->min('date_order');
        $periodEnd = Report::find()->max('date_order');

        $budget = 0;

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['periodStart'])) {
            $periodStart = $_GET['periodStart'];
            $periodEnd = $_GET['periodEnd'];
            $budget = $_GET['budget'];
        }

        $bigQty = $bigSum = $bigDiscount = $bigDelivery = $bigPlatform = [];
        $smallQty = $smallSum = $smallDiscount = $smallDelivery = $smallPlatform = [];
        $bigIncomingPriceSum = $smallIncomingPriceSum = [];
        $noPackage = [];

        $agroprocvit = [];
        $faceBook = [];
        $instagram = [];
        $dzvinok = [];


        $platformName = ['Агропроцвіт', 'FaceBook', 'Instagram', 'Дзвінок'];

        $models = Report::find()
            ->select(['id', 'platform', 'date_delivery', 'price_delivery', 'order_status_id', 'order_pay_ment_id'])
            ->where(['between', 'date_order', $periodStart, $periodEnd])
            ->andWhere(['platform' => $platformName])
            ->andWhere(['<>', 'order_status_id', 'Відміна'])
            ->andWhere(['<>', 'order_pay_ment_id', 'Відміна'])
            ->all();

        foreach ($models as $model) {
            $platform = $model->platform;
            $package = $model->getPackage($model->id);
            $totalSum = $model->getTotalSumPeriod($model->id);
            $incomingPriceSum = $model->getItemsIncomingPrice($model->id);
            $discount = $model->getItemsDiscount($model->id);
            $platformPrice = $model->getItemsPlatformPrice($model->id);
            $priceDelivery = $model->price_delivery;

            if ($model->order_status_id != 'Повернення' or $model->order_pay_ment_id != 'Повернення') {


                switch ($platform) {
                    case 'Агропроцвіт':
                        $agroprocvit[] = $platform;
                        break;
                    case 'FaceBook':
                        $faceBook[] = $platform;
                        break;
                    case 'Instagram':
                        $instagram[] = $platform;
                        break;
                    case 'Дзвінок':
                        $dzvinok[] = $platform;
                        break;
                    default:
                        $noPackage[] = 'Не визначено';
                        break;
                }


                switch ($package) {
                    case 'Фермерська':
                        $bigQty[] = $package;
                        $bigSum[] = $totalSum;
                        $bigIncomingPriceSum[] = $incomingPriceSum;
                        $bigDiscount[] = $discount;
                        $bigPlatform[] = $platformPrice;
                        $bigDelivery[] = $priceDelivery;
                        break;
                    case 'Дрібна':
                        $smallQty[] = $package;
                        $smallSum[] = $totalSum;
                        $smallIncomingPriceSum[] = $incomingPriceSum;
                        $smallDiscount[] = $discount;
                        $smallPlatform[] = $platformPrice;
                        $smallDelivery[] = $priceDelivery;
                        break;
                    case 'Фермерська + Дрібна':
                        $bigQty[] = 'BIG';
                        $smallQty[] = 'SMALL';
                        $smallDelivery[] = $priceDelivery;
                        $items = ReportItem::find()->where(['order_id' => $model->id])->asArray()->all();
                        foreach ($items as $item) {
                            $quantity = $item['quantity'];
                            if ($item['package'] == 'BIG') {
                                $bigSum[] = $item['price'] * $quantity;
                                $bigIncomingPriceSum[] = $item['entry_price'] * $quantity;
                                $bigDiscount[] = $item['discount'];
                                $bigPlatform[] = $item['platform_price'];
                            } else {
                                $smallSum[] = $item['price'] * $quantity;
                                $smallIncomingPriceSum[] = $item['entry_price'] * $quantity;
                                $smallDiscount[] = $item['discount'];
                                $smallPlatform[] = $item['platform_price'];
                            }
                        }
                        break;
                    default:
                        $noPackage[] = 'Не визначено';
                        break;
                }
            } else {
                switch ($package) {
                    case 'Фермерська + Дрібна':
                    case 'Фермерська':
                        $bigDelivery[] = $priceDelivery;
                        break;
                    case 'Дрібна':
                        $smallDelivery[] = $priceDelivery;
                        break;
                    default:
                        $noPackage[] = 'Не визначено';
                        break;
                }
            }

        }

        $agroprocvitCount = count($agroprocvit);
        $faceBookCount = count($faceBook);
        $instagramCount = count($instagram);
        $dzvinokCount = count($dzvinok);

        $bigQtyCount = count($bigQty);
        $bigSumTotal = array_sum($bigSum);
        $smallQtyCount = count($smallQty);
        $smallSumTotal = array_sum($smallSum);
        $bigDiscountTotal = array_sum($bigDiscount);
        $bigDeliveryTotal = array_sum($bigDelivery);
        $bigPlatformTotal = array_sum($bigPlatform);
        $smallDiscountTotal = array_sum($smallDiscount);
        $smallDeliveryTotal = array_sum($smallDelivery);
        $smallPlatformTotal = array_sum($smallPlatform);
        $bigIncomingPriceSumTotal = array_sum($bigIncomingPriceSum);
        $smallIncomingPriceSumTotal = array_sum($smallIncomingPriceSum);

        return $this->render('advertising-report', [
            'agroprocvitCount' => $agroprocvitCount,
            'faceBookCount' => $faceBookCount,
            'instagramCount' => $instagramCount,
            'dzvinokCount' => $dzvinokCount,
            'model' => $models,
            'budget' => $budget,
            'bigQty' => $bigQtyCount,
            'bigSum' => $bigSumTotal,
            'periodEnd' => $periodEnd,
            'smallQty' => $smallQtyCount,
            'smallSum' => $smallSumTotal,
            'periodStart' => $periodStart,
            'bigDiscount' => $bigDiscountTotal,
            'bigDelivery' => $bigDeliveryTotal,
            'bigPlatform' => $bigPlatformTotal,
            'smallDiscount' => $smallDiscountTotal,
            'smallDelivery' => $smallDeliveryTotal,
            'smallPlatform' => $smallPlatformTotal,
            'bigIncomingPriceSum' => $bigIncomingPriceSumTotal,
            'smallIncomingPriceSum' => $smallIncomingPriceSumTotal,
        ]);
    }

    public function actionAssistant()
    {
        return $this->render('assistant');
    }

    public function actionReportExportToExcel($package = null)
    {
        $sumOrders = [];
        $sumNovaPay = [];
        $sumIncomingOrders = [];
        $sumDiscountOrders = [];
        $sumPlatformOrders = [];
        $sumDeliveryOrders = [];
        $countsOrders = [];
        $periodStart = Yii::$app->session->get('periodStart');
        $periodEnd = Yii::$app->session->get('periodEnd');

        if ($package === null) {
            $models = Report::find()
                ->where(['between', 'date_order', $periodStart, $periodEnd])
                ->orderBy(['date_order' => SORT_ASC])
                ->all();
        } else {
            $models = Report::find()
                ->joinWith('reportItems')
                ->where(['between', 'date_order', $periodStart, $periodEnd])
                ->andWhere(['report_item.package' => $package])
                ->orderBy(['date_order' => SORT_ASC])
                ->all();
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Платформа');
        $sheet->setCellValue('B1', '№ Замовлення');
        $sheet->setCellValue('C1', 'Статус Замов.');
        $sheet->setCellValue('D1', 'Дата Відвантаження');
        $sheet->setCellValue('E1', 'Назва Товару');
        $sheet->setCellValue('F1', 'К-ть');
        $sheet->setCellValue('G1', 'Вхід');
        $sheet->setCellValue('H1', 'Ціна (продажна)');
        $sheet->setCellValue('I1', 'Сума по Товару');
        $sheet->setCellValue('J1', 'Сума Загал.');
        $sheet->setCellValue('K1', 'NovaPay');
        $sheet->setCellValue('L1', 'Знижка');
        $sheet->setCellValue('M1', 'Списання з Платформи');
        $sheet->setCellValue('N1', 'Доставка');
        $sheet->setCellValue('O1', 'Дата Оплати');
        $sheet->setCellValue('P1', 'Статус Оплати');
        $sheet->setCellValue('Q1', 'Тип Оплати');
        $sheet->setCellValue('R1', 'П.І.Б');
        $sheet->setCellValue('S1', 'моб Телефон');
        $sheet->setCellValue('T1', 'Адреса');
        $sheet->setCellValue('U1', 'ТТН');

        $headTableStyle = [
            'font' => [
                'size' => 14,
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '92d050', // Зеленый цвет
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Черный цвет границы
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $bodyTableStyleGrey = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'e5eded', // Цвет заливки
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'd5d4d7b8'], // Черный цвет границы
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $bodyTableStyleWhite = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'fff', // Цвет заливки
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'd5d4d7b8'], // Черный цвет границы
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $footerTableStyle = [
            'font' => [
                'size' => 14,
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'F77575', // Цвет заливки
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'd5d4d7b8'], // Черный цвет границы
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        $sheet->getStyle('A1:U1')->applyFromArray($headTableStyle);
        $sheet->freezePane('A2');
        foreach (range('A', 'U') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->getStyle('G:G')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle('H:H')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle('I:I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle('J:J')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle('K:K')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle('L:L')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle('M:M')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle('N:N')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle('U:U')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);


        $row = 2; // начнем с второй строки
        $j = 0;
        foreach ($models as $model) {

            $countsOrders[] = 1;
            $sumNovaPay[] = $model->nova_pay;
            $sumDeliveryOrders[] = $model->price_delivery;
            $i = 0;
            if ($j % 2 === 0) {
                $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($bodyTableStyleGrey);
            } else {
                $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($bodyTableStyleWhite);
            }

            switch ($model->order_status_id) {

                case 'Доставляється':
                    $orderStatusStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'EBBA11', // Цвет заливки
                            ],
                        ],
                    ];
                    break;
                case 'Відміна':
                    $orderStatusStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '8A8682', // Цвет заливки
                            ],
                        ],
                        'font' => [
                            'color' => [
                                'rgb' => Color::COLOR_WHITE, // Цвет текста
                            ],
                        ],
                    ];
                    break;
                case 'Повернення':
                    $orderStatusStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'F83B2B', // Цвет заливки
                            ],
                        ],
                        'font' => [
                            'color' => [
                                'rgb' => Color::COLOR_WHITE, // Цвет текста
                            ],
                        ],
                    ];
                    break;
                case 'Комплектується':
                    $orderStatusStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'FAFA56', // Цвет заливки
                            ],
                        ],
                    ];
                    break;
                case 'Одержано':
                    $orderStatusStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '65D542', // Цвет заливки
                            ],
                        ],
                    ];
                    break;
                case 'Очікується':
                    $orderStatusStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '8ED5F4', // Цвет заливки
                            ],
                        ],
                    ];
                    break;
                default;
                    $orderStatusStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '010C11', // Цвет заливки
                            ],
                        ],
                        'font' => [
                            'color' => [
                                'rgb' => Color::COLOR_WHITE, // Цвет текста
                            ],
                        ],
                    ];
                    break;
            }

            switch ($model->order_pay_ment_id) {

                case 'Не оплачено':
                    $orderPaymentStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'EBBA11', // Цвет заливки
                            ],
                        ],
                    ];
                    break;
                case 'Оплачено':
                    $orderPaymentStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '65D542', // Цвет заливки
                            ],
                        ],
                    ];
                    break;
                case 'Повернення':
                    $orderPaymentStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'F83B2B', // Цвет заливки
                            ],
                        ],
                        'font' => [
                            'color' => [
                                'rgb' => Color::COLOR_WHITE, // Цвет текста
                            ],
                        ],
                    ];
                    break;
                case 'Відміна':
                    $orderPaymentStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '8A8682', // Цвет заливки
                            ],
                        ],
                        'font' => [
                            'color' => [
                                'rgb' => Color::COLOR_WHITE, // Цвет текста
                            ],
                        ],
                    ];
                    break;
                default;
                    $orderPaymentStyle = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '010C11', // Цвет заливки
                            ],
                        ],
                        'font' => [
                            'color' => [
                                'rgb' => Color::COLOR_WHITE, // Цвет текста
                            ],
                        ],
                    ];
                    break;
            }

            $date_delivery = $model->date_delivery ? Yii::$app->formatter->asDate($model->date_delivery, 'php:d-m-Y') : '';
            $date_payment = $model->date_payment ? Yii::$app->formatter->asDate($model->date_payment, 'php:d-m-Y') : '';

            $sheet->setCellValue('A' . $row, $model->platform);
            $sheet->setCellValue('B' . $row, $model->number_order);
            $sheet->setCellValue('C' . $row, $model->order_status_id);
            $sheet->setCellValue('D' . $row, $date_delivery);
            $sheet->setCellValue('K' . $row, $model->nova_pay);
            $sheet->setCellValue('N' . $row, $model->price_delivery);
            $sheet->setCellValue('O' . $row, $date_payment);
            $sheet->setCellValue('P' . $row, $model->order_pay_ment_id);
            $sheet->setCellValue('Q' . $row, $model->type_payment);
            $sheet->setCellValue('R' . $row, $model->fio);
            $sheet->setCellValue('S' . $row, $model->tel_number);
            $sheet->setCellValue('T' . $row, $model->address);
            $sheet->setCellValue('U' . $row, $model->ttn);

            if ($package === null){
                $products = ReportItem::find()
                    ->where(['order_id' => $model->id])
                    ->all();
            }else{
                $products = ReportItem::find()
                    ->where(['order_id' => $model->id])
                    ->andWhere(['package' => $package])
                    ->all();
            }

            $k = 0;
            $sumOrder = [];
            foreach ($products as $product) {
                $sumOrder[] = $product->price * $product->quantity;
                $sumOrders[] = $product->price * $product->quantity;
                $sumIncomingOrders[] = $product->entry_price * $product->quantity;
                $sumDiscountOrders[] = $product->discount;
                $sumPlatformOrders[] = $product->platform_price;

                if ($j % 2 === 0) {
                    $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($bodyTableStyleGrey);
                } else {
                    $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($bodyTableStyleWhite);
                }

                if ($k < 1) {
                    if ($model->order_status_id != null or $model->order_status_id != '') {
                        $sheet->getStyle('C' . $row)->applyFromArray($orderStatusStyle);
                    }
                    if ($model->order_pay_ment_id != null or $model->order_pay_ment_id != '') {
                        $sheet->getStyle('P' . $row)->applyFromArray($orderPaymentStyle);
                    }
                }

                $sheet->setCellValue('E' . $row, $product->product_name);
                $sheet->setCellValue('F' . $row, $product->quantity);
                $sheet->setCellValue('G' . $row, $product->entry_price);
                $sheet->setCellValue('H' . $row, $product->price);
                $sheet->setCellValue('I' . $row, $product->price * $product->quantity);
                $sheet->setCellValue('L' . $row, $product->discount);
                $sheet->setCellValue('M' . $row, $product->platform_price);
                $row++;
                $i = 1;
                $k++;
            }
            $sheet->setCellValue('J' . ($row - $k), array_sum($sumOrder));
            if ($i === 0) {
                $row++;
            }
            $j++;
        }

        $countsOrders = array_sum($countsOrders);
        $sumOrders = array_sum($sumOrders);
        $sumNovaPay = array_sum($sumNovaPay);
        $sumIncomingOrders = array_sum($sumIncomingOrders);
        $sumDiscountOrders = array_sum($sumDiscountOrders);
        $sumPlatformOrders = array_sum($sumPlatformOrders);
        $sumDeliveryOrders = array_sum($sumDeliveryOrders);

        $periodStart = Yii::$app->formatter->asDate($periodStart, 'php:d-m-Y');
        $periodEnd = Yii::$app->formatter->asDate($periodEnd, 'php:d-m-Y');

        $sheet->setCellValue('A' . $row, 'Всього:');
        $sheet->setCellValue('B' . $row, $countsOrders);
        $sheet->setCellValue('D' . $row, 'з ' . $periodStart . ' по ' . $periodEnd);
        $sheet->setCellValue('G' . $row, $sumIncomingOrders);
        $sheet->setCellValue('I' . $row, $sumOrders);
        $sheet->setCellValue('L' . $row, $sumDiscountOrders);
        $sheet->setCellValue('M' . $row, $sumPlatformOrders);
        $sheet->setCellValue('K' . $row, $sumNovaPay);
        $sheet->setCellValue('N' . $row, $sumDeliveryOrders);

        $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($footerTableStyle);

        ob_start();

        try {
            $writer = new Xlsx($spreadsheet);
            $file_name = 'report__' . $periodStart . '__' . $periodEnd . '___' . date('d_m_Y', time()) . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $file_name . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            Yii::$app->end();
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }

        ob_end_flush();
    }

    public function actionCheckOrderNumber($number)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $exists = Report::find()->where(['number_order' => $number])->exists();
        return ['exists' => $exists];
    }

    /**
     * Finds the Report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Report::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAjaxUpdateOrderStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $status = Yii::$app->request->post('status');

        $model = Report::findOne($id);
        if (!$model) {
            return ['status' => 'error', 'message' => 'Замовлення не знайдено'];
        }

        $model->order_status_id = $status;

        if ($model->save()) {
            return ['status' => 'ok', 'message' => 'Статус оновлено!'];
        }

        return ['status' => 'error', 'message' => 'Не вдалося оновити статус'];
    }

    public function actionAjaxUpdateOrderPayment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $status = Yii::$app->request->post('status');

        $model = Report::findOne($id);
        if (!$model) {
            return ['status' => 'error', 'message' => 'Замовлення не знайдено'];
        }

        $model->order_pay_ment_id = $status;

        if ($model->save()) {
            return ['status' => 'ok', 'message' => 'Статус оновлено!'];
        }

        return ['status' => 'error', 'message' => 'Не вдалося оновити статус'];
    }
}