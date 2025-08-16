<?php

namespace backend\controllers;

use common\models\Slider;
use backend\models\search\SliderSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SliderController implements the CRUD actions for Slider model.
 */
class SliderController extends Controller
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
     * Lists all Slider models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slider model.
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
     * Creates a new Slider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Slider();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $dir = Yii::getAlias('@frontendWeb/images/slider/');

                $file = UploadedFile::getInstance($model, 'image');
                $imageName = uniqid();
                $file->saveAs($dir . $imageName . '.' . $file->extension);
                $model->image = $imageName . '.' . $file->extension;

                $file_mob = UploadedFile::getInstance($model, 'image_mob');
                $imageName_mob = uniqid();
                $file_mob->saveAs($dir . $imageName_mob . '.' . $file_mob->extension);
                $model->image_mob = $imageName_mob . '.' . $file_mob->extension;

                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Slider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $post_file = $_FILES['Slider']['size']['image'];
            if($post_file <= 0 ){
                $old = $this->findModel($id);
                $model->image = $old->image;
            }else {
                $dir = Yii::getAlias('@frontendWeb/images/slider/');
                $file = UploadedFile::getInstance($model, 'image');
                $imageName = uniqid();
                $file->saveAs($dir . $imageName . '.' . $file->extension);
                $model->image = $imageName . '.' . $file->extension;
            }
            $post_file_mob = $_FILES['Slider']['size']['image_mob'];
            if($post_file_mob <= 0 ){
                $old = $this->findModel($id);
                $model->image_mob = $old->image_mob;
            }else {
                $dir = Yii::getAlias('@frontendWeb/images/slider/');
                $file_mob = UploadedFile::getInstance($model, 'image_mob');
                $imageName_mob = uniqid();
                $file_mob->saveAs($dir . $imageName_mob . '.' . $file_mob->extension);
                $model->image_mob = $imageName_mob . '.' . $file_mob->extension;
            }
                if($model->save()) {
                    return $this->redirect(['update', 'id' => $model->id]);
                }else{
                    dd($model->errors);
                    die;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Slider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $dir = Yii::getAlias('@frontendWeb/images');
        $model = $this->findModel($id);
        if (file_exists($dir .'/slider/'. $model->image)) {
            unlink($dir .'/slider/'. $model->image);
        }
        if (file_exists($dir .'/slider/'. $model->image_mob)) {
            unlink($dir .'/slider/'. $model->image_mob);
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Slider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Slider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slider::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
