<?php

namespace backend\controllers;

use common\models\shop\CategoriesProperties;
use common\models\shop\PropertiesName;
use backend\models\search\PropertiesNameSearch;
use common\models\shop\PropertiesNameTranslate;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PropertiesNameController implements the CRUD actions for PropertiesNameSearch model.
 */
class PropertiesNameController extends Controller
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
     * Lists all PropertiesNameSearch models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PropertiesNameSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PropertiesNameSearch model.
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
     * Creates a new PropertiesNameSearch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PropertiesName();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                $this->getCreateTranslate($model);

                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    protected function getCreateTranslate($model)
    {
        $sourceLanguage = 'uk'; // Исходный язык
        $targetLanguages = ['ru']; // Языки перевода

        $tr = new GoogleTranslate();

        foreach ($targetLanguages as $language) {
            $translation = new PropertiesNameTranslate();
            $translation->name_id = $model->id;
            $translation->language = $language;

            $tr->setSource($sourceLanguage);
            $tr->setTarget($language);

            $translation->name = $tr->translate($model->name ?? '');

            $translation->save();
        }
    }

    /**
     * Updates an existing PropertiesNameSearch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $translateRu = PropertiesNameTranslate::findOne(['name_id' => $id, 'language' => 'ru']);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            $postTranslates = Yii::$app->request->post('PropertyTranslate', []);

            $this->updateTranslate($id, 'ru', $postTranslates['ru'] ?? null);

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'translateRu' => $translateRu,
        ]);
    }

    private function updateTranslate($id, $language, $data)
    {
        if ($data) {
            $translate = PropertiesNameTranslate::findOne(['name_id' => $id, 'language' => $language]);
            if ($translate) {
                $translate->setAttributes($data);
                $translate->save();
            }
        }
    }

    /**
     * Deletes an existing PropertiesNameSearch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        CategoriesProperties::deleteAll(['property_id' => $id]);
        PropertiesNameTranslate::deleteAll(['name_id' => $id]);

        $model->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the PropertiesNameSearch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PropertiesName the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PropertiesName::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
