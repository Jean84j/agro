<?php

namespace backend\controllers;

use backend\models\competitors\CompetitorPrice;
use backend\models\Competitors\Competitors;
use backend\models\search\CompetitorsSearch;
use common\models\shop\Product;
use Yii;
use yii\base\BaseObject;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CompetitorsController implements the CRUD actions for Competitors model.
 */
class CompetitorsController extends Controller
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
     * Lists all Competitors models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CompetitorsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Competitors model.
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
     * Creates a new Competitors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Competitors();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Competitors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $competitors = CompetitorPrice::find()->where(['product_id' => $model->product_id])->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'competitors' => $competitors,
        ]);
    }

    /**
     * Deletes an existing Competitors model.
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
     * Finds the Competitors model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Competitors the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Competitors::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public
    function actionAddCompetitors()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->getRawBody();  // Получаем сырые данные

            // Декодируем JSON
            $data = json_decode($data, true);

            // Проверяем наличие данных
            if (isset($data['productId'], $data['link'])) {

                $productId = $data['productId'];
                $link = $data['link'];


                $modelPrice = new CompetitorPrice();
                $modelPrice->product_id = $productId;
                $modelPrice->url = $link;

                $domain = parse_url($link, PHP_URL_HOST);
                $modelPrice->name = $domain;


                if (!$modelPrice->save()) {
                    dd($modelPrice->errors);
                }


                $competitors = CompetitorPrice::find()
                    ->where(['product_id' => $productId])
                    ->asArray()
                    ->all();

                $model = Competitors::find()->where(['product_id' => $productId])->one();

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'competitors' => $this->renderPartial('competitors-url/_competitors-table', [
                        'competitors' => $competitors,
                        'model' => $model
                    ]),
                ];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => false, 'error' => 'Не всі дані передані контроллер.'];
            }
        }
        throw new BadRequestHttpException('Некоректний запит.');
    }



    public
    function actionEditCompetitors()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->getRawBody();  // Получаем сырые данные

            // Декодируем JSON
            $data = json_decode($data, true);

            // Проверяем наличие данных
            if (isset($data['id'], $data['productId'], $data['link'])) {
                $id = $data['id'];
                $productId = $data['productId'];
                $link = $data['link'];


                $model = CompetitorPrice::find()->where(['id' => $id])->one();
                $model->url = $link;

                if (!$model->save()) {
                   dd($model->errors);
                }

                $competitors = CompetitorPrice::find()
                    ->where(['product_id' => $productId])
                    ->asArray()
                    ->all();

                $model = Competitors::find()->where(['product_id' => $productId])->one();

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'competitors' => $this->renderPartial('competitors-url/_competitors-table', [
                        'competitors' => $competitors,
                        'model' => $model
                    ]),
                ];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => false, 'error' => 'Не всі дані передані контроллер.'];
            }
        }
        throw new BadRequestHttpException('Некоректний запит.');
    }



    public function actionDeleteCompetitor()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException('Некорректный запрос.');
        }

        $id = Yii::$app->request->post('id');
        $productId = Yii::$app->request->post('productId');

        if (!$id || !$productId) {
            return ['success' => false, 'error' => 'Недостаточно данных.'];
        }

        $model = CompetitorPrice::findOne($id);
        if (!$model->delete()) {
           dd($model->errors);
        }

        $competitors = CompetitorPrice::find()
            ->where(['product_id' => $productId])
            ->asArray()
            ->all();

        $model = Competitors::find()->where(['product_id' => $productId])->one();

        return [
            'success' => true,
            'competitors' => $this->renderPartial('competitors-url/_competitors-table', [
                'competitors' => $competitors,
                'model' => $model
            ]),
        ];
    }

    /**
     * Проверка name при вводе на уникальность.
     */
    public function actionCheckName($link)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $exists = CompetitorPrice::find()->where(['url' => $link])->exists();
        return ['exists' => $exists];
    }
}
