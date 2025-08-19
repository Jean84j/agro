<?php

namespace backend\controllers;

use common\models\shop\Order;
use backend\models\search\OrderSearch;
use common\models\shop\OrderItem;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
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
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
//        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', ' Інформація про замовлення оновлена!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAddOrderItem()
    {
        $model = new OrderItem();
        if (Yii::$app->request->isGet) {

            $order_item = Yii::$app->request->get();

            $model->order_id = $order_item['orderId'];
            $model->product_id = $order_item['productId'];
            $model->quantity = $order_item['quantity'];
            $model->price = $model->getPrice($order_item['productId']);
            $model->save(true);

        }
        return $this->redirect(['view', 'id' => $order_item['orderId']]);
    }

    public function actionUpdateOrderItem()
    {
        if (Yii::$app->request->isGet) {

            $order_item = Yii::$app->request->get();
            $item = OrderItem::find()->where(['id' => $order_item['orderItemId']])->one();

            $item->quantity = $order_item['quantity'];
            $item->price = $order_item['price'];
            $item->save(true);

            return $this->redirect(['view', 'id' => $item->order_id]);
        }
    }

    public function actionDeleteOrderItem($id)
    {
        $orderItem = OrderItem::findOne($id);
        if ($orderItem) {
            $orderItem->delete();

            return $this->redirect(['view', 'id' => $orderItem->order_id]);
        } else {
            throw new NotFoundHttpException('Товар не найден');
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
