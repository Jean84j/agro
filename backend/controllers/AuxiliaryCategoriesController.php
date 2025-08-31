<?php

namespace backend\controllers;

use common\models\shop\AuxiliaryCategories;
use backend\models\search\AuxiliaryCategoriesSearch;
use common\models\shop\AuxiliaryTranslate;
use Yii;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AuxiliaryCategoriesController implements the CRUD actions for AuxiliaryCategoriesSearch model.
 */
class AuxiliaryCategoriesController extends Controller
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
     * Lists all AuxiliaryCategoriesSearch models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuxiliaryCategoriesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuxiliaryCategoriesSearch model.
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
     * Creates a new AuxiliaryCategoriesSearch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AuxiliaryCategories();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->image = $this->uploadFile($model);

                if ($model->save()) {

                    $this->getDeeplTranslate($model);

                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    protected function getDeeplTranslate($model)
    {
        $sourceLanguage = 'UK'; // DeepL ждет большие буквы
        $targetLanguages = ['RU'];

        $tr = Yii::$app->deepl; // берем наш компонент

        foreach ($targetLanguages as $language) {
            $translation = $model->getTranslation(strtolower($language))->one();
            if (!$translation) {
                $translation = new AuxiliaryTranslate();
                $translation->category_id = $model->id;
                $translation->language = strtolower($language);
            }

            $translation->name = $tr->translate($model->name ?? '', $language, $sourceLanguage);

            $translation->description = $tr->translate($model->description ?? '', $language, $sourceLanguage);

            $translation->pageTitle = $tr->translate($model->pageTitle ?? '', $language, $sourceLanguage);
            $translation->metaDescription = $tr->translate($model->metaDescription ?? '', $language, $sourceLanguage);
            $translation->h1 = $tr->translate($model->h1 ?? '', $language, $sourceLanguage);
            $translation->keywords = $tr->translate($model->keywords ?? '', $language, $sourceLanguage);

            $translation->save();
        }
    }

    /**
     * Updates an existing AuxiliaryCategoriesSearch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $translateRu = AuxiliaryTranslate::findOne(['category_id' => $id, 'language' => 'ru']);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $postTranslates = Yii::$app->request->post('Translate', []);

            $this->updateTranslate($model->id, 'ru', $postTranslates['ru'] ?? null);

            if ($_FILES['AuxiliaryCategories']['size']['image'] > 0) {
                $model->image = $this->uploadFile($model);
            } else {
                $old = $this->findModel($id);
                $model->image = $old->image;
            }

            if ($model->save(false)) {
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                dd($model->errors, $model->image);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'translateRu' => $translateRu,
        ]);
    }

    private function updateTranslate($categoryId, $language, $data)
    {
        if ($data) {
            $translate = AuxiliaryTranslate::findOne(['category_id' => $categoryId, 'language' => $language]);
            if ($translate) {
                $translate->setAttributes($data);
                $translate->save();
            }
        }
    }

    private function uploadFile($model)
    {
        $dir = Yii::getAlias('@frontendWeb/images/auxiliary-categories/');
        $file = UploadedFile::getInstance($model, 'image');
        if (empty($model->slug)) {
            $imageName = Inflector::slug($model->name);
        } else {
            $imageName = $model->slug;
        }
        $file->saveAs($dir . $imageName . '.' . $file->extension);
        return $imageName . '.' . $file->extension;
    }

    /**
     * Deletes an existing AuxiliaryCategoriesSearch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $dir = Yii::getAlias('@frontendWeb/images');
        $model = $this->findModel($id);
        if (file_exists($dir . '/auxiliary-categories/' . $model->image)) {
            unlink($dir . '/auxiliary-categories/' . $model->image);
        }

        AuxiliaryTranslate::deleteAll(['category_id' => $id]);

        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the AuxiliaryCategoriesSearch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AuxiliaryCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuxiliaryCategories::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
