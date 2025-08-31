<?php

namespace backend\controllers;

use common\models\shop\Brand;
use backend\models\search\BrandSearch;
use common\models\shop\BrandsTranslate;
use Yii;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
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
     * Lists all Brand models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Brand model.
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
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Brand();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->file = $this->uploadFile($model);

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
                $translation = new BrandsTranslate();
                $translation->brand_id = $model->id;
                $translation->language = strtolower($language);
            }

            $translation->description = $tr->translate($model->description ?? '', $language, $sourceLanguage);

            $translation->name = $model->name ?? '';
            $translation->seo_title = $tr->translate($model->seo_title ?? '', $language, $sourceLanguage);
            $translation->seo_description = $tr->translate($model->seo_description ?? '', $language, $sourceLanguage);
            $translation->h1 = $tr->translate($model->h1 ?? '', $language, $sourceLanguage);
            $translation->keywords = $tr->translate($model->keywords ?? '', $language, $sourceLanguage);

            $translation->save();
        }
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $translateRu = BrandsTranslate::findOne(['brand_id' => $id, 'language' => 'ru']);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $postTranslates = Yii::$app->request->post('Translate', []);

            $this->updateTranslate($model->id, 'ru', $postTranslates['ru'] ?? null);

            $post_file = $_FILES['Brand']['size']['file'];
            if ($post_file <= 0) {
                $old = $this->findModel($id);
                $model->file = $old->file;
            } else {
                $model->file = $this->uploadFile($model);
            }
            if ($model->save(false)) {
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                dd($model->errors, $model->file);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'translateRu' => $translateRu,
        ]);
    }

    private function updateTranslate($brandId, $language, $data)
    {
        if ($data) {
            $translate = BrandsTranslate::findOne(['brand_id' => $brandId, 'language' => $language]);
            if ($translate) {
                $translate->setAttributes($data);
                $translate->save();
            }
        }
    }

    private function uploadFile($model)
    {
        $dir = Yii::getAlias('@frontendWeb/images/brand/');
        $file = UploadedFile::getInstance($model, 'file');
        if (empty($model->slug)) {
            $imageName = Inflector::slug($model->name);
        }else{
            $imageName = $model->slug;
        }

        $file->saveAs($dir . $imageName . '.' . $file->extension);
        return $imageName . '.' . $file->extension;
    }

    /**
     * Deletes an existing Brand model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionDelete($id)
    {
        $dir = Yii::getAlias('@frontendWeb/images');
        $model = $this->findModel($id);
        if (file_exists($dir . '/brand/' . $model->file)) {
            unlink($dir . '/brand/' . $model->file);
        }

        BrandsTranslate::deleteAll(['brand_id' => $id]);

        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
