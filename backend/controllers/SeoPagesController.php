<?php

namespace backend\controllers;

use common\models\SeoPages;
use backend\models\search\SeoPagesSearch;
use common\models\SeoPageTranslate;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeoPagesController implements the CRUD actions for SeoPages model.
 */
class SeoPagesController extends Controller
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
     * Lists all SeoPages models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SeoPagesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SeoPages model.
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
     * Creates a new SeoPages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SeoPages();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $this->getCreateTranslate($model);
                return $this->redirect(['update', 'id' => $model->id]);
//                return $this->redirect('index');
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
                $translation = new SeoPageTranslate();
                $translation->page_id = $model->id;
                $translation->language = $language;
            }

            $tr->setSource($sourceLanguage);
            $tr->setTarget($language);

            $translation->title = $tr->translate($model->title ?? '');
            $translation->description = $tr->translate($model->description ?? '');

            if (strlen($model->page_description) < 5000) {
                $translation->page_description = $tr->translate($model->page_description);
            } else {
                $page_description = $model->page_description;
                $translatedDescription = '';
                $partSize = 5000;
                $parts = [];

                // Разбиваем текст на части по 5000 символов, не нарушая структуру тегов
                while (strlen($page_description) > $partSize) {
                    $part = substr($page_description, 0, $partSize);
                    $lastSpace = strrpos($part, ' ');
                    $parts[] = substr($page_description, 0, $lastSpace);
                    $page_description = substr($page_description, $lastSpace);
                }
                $parts[] = $page_description;

                // Переводим каждую часть отдельно
                foreach ($parts as $part) {
                    $translatedDescription .= $tr->translate($part);
                }

                // Сохраняем переведенное описание
                $translation->page_description = $translatedDescription;
            }

            $translation->save();
        }
    }

    /**
     * Updates an existing SeoPages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $translateRu = SeoPageTranslate::findOne(['page_id' => $id, 'language' => 'ru']);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $postTranslates = Yii::$app->request->post('SeoTranslate', []);

            $this->updateTranslate($model->id, 'ru', $postTranslates['ru'] ?? null);

            if ($model->save()) {
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

    private function updateTranslate($pageId, $language, $data)
    {
        if ($data) {
            $translate = SeoPageTranslate::findOne(['page_id' => $pageId, 'language' => $language]);
            if ($translate) {
                $translate->setAttributes($data);
                $translate->save();
            }
        }
    }

    /**
     * Deletes an existing SeoPages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        SeoPageTranslate::deleteAll(['page_id' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the SeoPages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SeoPages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SeoPages::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
