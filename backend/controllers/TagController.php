<?php

namespace backend\controllers;

use common\models\shop\ProductTag;
use common\models\shop\Tag;
use backend\models\search\TagSearch;
use common\models\TagTranslate;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
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
     * Lists all Tag models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tag model.
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
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tag();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

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
                $translation = new TagTranslate();
                $translation->tag_id = $model->id;
                $translation->language = strtolower($language);
            }

            $translation->name = $tr->translate($model->name ?? '', $language, $sourceLanguage);
            $translation->seo_title = $tr->translate($model->seo_title ?? '', $language, $sourceLanguage);
            $translation->seo_description = $tr->translate($model->seo_description ?? '', $language, $sourceLanguage);
            $translation->h1 = $tr->translate($model->h1 ?? '', $language, $sourceLanguage);
            $translation->keywords = $tr->translate($model->keywords ?? '', $language, $sourceLanguage);

            $translation->description = $tr->translate($model->description ?? '', $language, $sourceLanguage);


            $translation->save();
        }
    }

    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $translateRu = TagTranslate::findOne(['tag_id' => $id, 'language' => 'ru']);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $postTranslates = Yii::$app->request->post('Translate', []);

            $this->updateTranslate($model->id, 'ru', $postTranslates['ru'] ?? null);

            if ($model->save(false)) {
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                dd($model->errors);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'translateRu' => $translateRu,
        ]);
    }

    private function updateTranslate($tagId, $language, $data)
    {
        if ($data) {
            $translate = TagTranslate::findOne(['tag_id' => $tagId, 'language' => $language]);
            if ($translate) {
                $translate->setAttributes($data);
                $translate->save();
            }
        }
    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $tags = ProductTag::find()->where(['tag_id' => $model->id])->all();
        foreach ($tags as $tag) {

            $tag->delete();
        }

        TagTranslate::deleteAll(['tag_id' => $id]);

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
