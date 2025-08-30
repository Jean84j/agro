<?php

namespace backend\controllers;

use common\models\shop\CategoriesProperties;
use common\models\shop\CategoriesTranslate;
use common\models\shop\Category;
use backend\models\search\CategorySearch;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Yii;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->file = $this->uploadFile($model);

                if ($model->save()) {

                    $this->getCreateTranslate($model);

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

    protected function getCreateTranslate($model)
    {
        $sourceLanguage = 'uk'; // Исходный язык
        $targetLanguages = ['ru']; // Языки перевода

        $tr = new GoogleTranslate();

        foreach ($targetLanguages as $language) {
            $translation = $model->getTranslation($language)->one();
            if (!$translation) {
                $translation = new CategoriesTranslate();
                $translation->category_id = $model->id;
                $translation->language = $language;
            }

            $tr->setSource($sourceLanguage);
            $tr->setTarget($language);

            $translation->name = $tr->translate($model->name ?? '');

                if (strlen($model->description) < 5000) {
                    $translation->description = $tr->translate($model->description);
                } else {
                    $description = $model->description;
                    $translatedDescription = '';
                    $partSize = 5000;
                    $parts = [];

                    // Разбиваем текст на части по 5000 символов, не нарушая структуру тегов
                    while (strlen($description) > $partSize) {
                        $part = substr($description, 0, $partSize);
                        $lastSpace = strrpos($part, ' ');
                        $parts[] = substr($description, 0, $lastSpace);
                        $description = substr($description, $lastSpace);
                    }
                    $parts[] = $description;

                    // Переводим каждую часть отдельно
                    foreach ($parts as $part) {
                        $translatedDescription .= $tr->translate($part);
                    }

                    // Сохраняем переведенное описание
                    $translation->description = $translatedDescription;
                }

            $translation->pageTitle = $tr->translate($model->pageTitle ?? '');
            $translation->metaDescription = $tr->translate($model->metaDescription ?? '');
            $translation->prefix = $tr->translate($model->prefix ?? '');
            $translation->keywords = $tr->translate($model->keywords ?? '');
            $translation->product_keywords = $tr->translate($model->product_keywords ?? '');
            $translation->product_footer_description = $tr->translate($model->product_footer_description ?? '');
            $translation->product_title = $tr->translate($model->product_title ?? '');
            $translation->product_description = $tr->translate($model->product_description ?? '');
            $translation->save();
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $translateRu = CategoriesTranslate::findOne(['category_id' => $id, 'language' => 'ru']);

        if ($this->request->isPost && $model->load($this->request->post())) {

            $postCategory = Yii::$app->request->post('Category', []);
            $properties = $postCategory['properties'] ?? [];

            $this->updateCategoryProperties($model, $properties ?? null);

            $postTranslates = Yii::$app->request->post('SeoTranslate', []);

            $this->updateTranslate($model->id, 'ru', $postTranslates['ru'] ?? null);

            if ($_FILES['Category']['size']['file'] > 0) {
                $model->file = $this->uploadFile($model);
            } else {
                $old = $this->findModel($id);
                $model->file = $old->file;
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

    private function updateTranslate($categoryId, $language, $data)
    {
        if ($data) {
            $translate = CategoriesTranslate::findOne(['category_id' => $categoryId, 'language' => $language]);
            if ($translate) {
                $translate->setAttributes($data);
                $translate->save();
            }
        }
    }

    private function uploadFile($model)
    {
        $dir = Yii::getAlias('@frontendWeb/images/category/');
        $file = UploadedFile::getInstance($model, 'file');
        if (empty($model->slug)) {
            $imageName = Inflector::slug($model->name);
        }else{
            $imageName = $model->slug;
        }
        $file->saveAs($dir . $imageName . '.' . $file->extension);
        return $imageName . '.' . $file->extension;
    }

    private
    function updateCategoryProperties($model, $data)
    {
        if (!empty($data)) {
            $properties = CategoriesProperties::find()->where(['category_id' => $model->id])->all();
            if ($properties) {
                foreach ($properties as $p) {
                    $p->delete();
                }
            }

            foreach ($data as $datum_id) {
                $property = CategoriesProperties::find()
                    ->where(['category_id' => $model->id])
                    ->andWhere(['property_id' => $datum_id])
                    ->one();
                if (!$property) {
                    $add_property = new CategoriesProperties();
                    $add_property->category_id = $model->id;
                    $add_property->property_id = $datum_id;
                    $add_property->save();
                }
            }
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $dir = Yii::getAlias('@frontendWeb/images');
        $model = $this->findModel($id);

        if (file_exists($dir . '/category/' . $model->file)) {
            unlink($dir . '/category/' . $model->file);
        }

        CategoriesTranslate::deleteAll(['category_id' => $id]);

        $model->delete();


        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionUpdateVisibility()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $value = Yii::$app->request->post('value');

         $model = Category::findOne($id);
         $model->visibility = $value;
         if ($model->save()){
             $message = ' Збережено Нове Значення ! ! ! ';
             $background = 'bg-success';
         }else{
             $message = ' Сталася Помилка ! ! ! ';
             $background = 'bg-danger';
         }

        return [
            'status' => 'ok',
            'message' => $message,
            'background' => $background,

        ];
    }

}
