<?php

namespace backend\controllers;

use backend\models\SeoWords;
use common\models\shop\CategoriesProperties;
use common\models\shop\CategoriesTranslate;
use common\models\shop\Category;
use common\models\shop\Faq;
use common\models\shop\FaqTranslate;
use common\models\shop\ProductPackaging;
use common\models\shop\ProductPropertiesTranslate;
use common\models\shop\ProductsTranslate;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\filters\VerbFilter;
use common\models\Settings;
use backend\models\UploadForm;
use backend\models\ProductsBackend;
use yii\web\NotFoundHttpException;
use common\models\shop\ProductGrup;
use common\models\shop\ProductTag;
use common\models\shop\ProductImage;
use common\models\shop\AnalogProducts;
use backend\models\search\ProductSearch;
use common\models\shop\ProductProperties;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search();
        $currency = Settings::currencyRate();

        $seoErrors = Yii::$app->session->get('errorsSeo');
        if (!$seoErrors) {
            Yii::$app->session->set('errorsSeo', 'no');
        }

        return $this->render('index-grid', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'currency' => $currency,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductsBackend();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $post_product = $this->request->post('Product');
                $model->sku = 'PRO-100' . $model->id;

                $this->getCreateTranslate($model);

                $this->createProductTags($model, $post_product ?? null);
                $this->createProductAnalogs($model, $post_product ?? null);
                $this->createProductGrups($model, $post_product ?? null);

                $this->createProductProperties($model);
                $this->createProductLayout($model);

                $model->save();

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
        $targetLanguages = ['ru']; // Языки перевода

        $tr = new GoogleTranslate();

        foreach ($targetLanguages as $language) {
            $translation = $model->getTranslation($language)->one();
            if (!$translation) {
                $translation = new ProductsTranslate();
                $translation->product_id = $model->id;
                $translation->language = $language;
            }

            $tr->setSource();
            $tr->setOptions([
                'model' => 'nmt',
            ]);
            $tr->setTarget($language);

            $translation->name = $tr->translate($model->name);

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

            $translation->short_description = $tr->translate($model->short_description);
            $translation->seo_title = $tr->translate((string) $model->seo_title);
            $translation->seo_description = $tr->translate((string) $model->seo_description);
            $translation->h1 = $tr->translate((string) $model->h1);

            $categoryProductLayout = CategoriesTranslate::find()
                ->select([
                    'product_keywords',
                    'product_footer_description',
                    'product_title',
                    'product_description',
                ])
                ->where(['category_id' => $model->category_id])
                ->andWhere(['language' => $language])
                ->asArray()
                ->one();

            if ($categoryProductLayout) {
                $translation->keywords = $categoryProductLayout['product_keywords'] ?? null;
                $translation->footer_description = $categoryProductLayout['product_footer_description'] ?? null;
                $translation->seo_title = $categoryProductLayout['product_title'] ?? null;
                $translation->seo_description = $categoryProductLayout['product_description'] ?? null;
                $translation->seo_title = $this->generateSeo($model->name, $categoryProductLayout['product_title']) ?? null;
                $translation->seo_description = $this->generateSeo($model->name, $categoryProductLayout['product_description']) ?? null;
            } else {
                $translation->keywords = null;
                $translation->footer_description = null;
                $translation->seo_title = null;
                $translation->seo_description = null;
            }

            $translation->save();
        }
    }

    private function createProductTags($model, $post_product)
    {
        if (isset($post_product['tags']) && $post_product['tags'] != null) {
            //добавляем Tags
            foreach ($post_product['tags'] as $tag_id) {
                $add_tag = new ProductTag();
                $add_tag->product_id = $model->id;
                $add_tag->tag_id = $tag_id;
                $add_tag->save();
            }
        }
    }

    private function createProductAnalogs($model, $post_product)
    {
        if (isset($post_product['analogs']) && $post_product['analogs'] != null) {
            foreach ($post_product['analogs'] as $analog_id) {
                $add_analog = new AnalogProducts();
                $add_analog->product_id = $model->id;
                $add_analog->analog_product_id = $analog_id;
                $add_analog->save();
            }
        }
    }

    private function createProductGrups($model, $post_product)
    {
        if (isset($post_product['grups']) && $post_product['grups'] != null) {
            foreach ($post_product['grups'] as $grup_id) {
                $add_grup = new ProductGrup();
                $add_grup->product_id = $model->id;
                $add_grup->grup_id = $grup_id;
                $add_grup->save();
            }
        }
    }

    private function createProductProperties($model)
    {
        $categoryProperties = CategoriesProperties::find()
            ->alias('cp')
            ->select([
                'cp.property_id',
                'pn.sort',
                'MAX(CASE WHEN pnt.language = "ru" THEN pnt.id END) AS id_ru',
                'MAX(CASE WHEN pnt.language = "en" THEN pnt.id END) AS id_en'
            ])
            ->leftJoin(
                'properties_name pn',
                'pn.id = cp.property_id'
            )
            ->leftJoin(
                'properties_name_translate pnt',
                'pnt.name_id = pn.id'
            )
            ->where(['category_id' => $model->category_id])
            ->groupBy(['cp.property_id', 'pnt.name_id', 'pn.sort'])
            ->asArray()
            ->all();

        $languages = ['ru'];
        foreach ($categoryProperties as $property) {
            $productProperties = new ProductProperties();
            $productProperties->property_id = $property['property_id'];
            $productProperties->value = '';
            $productProperties->product_id = $model->id;
            $productProperties->category_id = $model->category_id;
            if ($productProperties->save()) {
                foreach ($languages as $language) {
                    if ($language == 'ru') {
                        $propertyName_id = $property['id_ru'];
                    } else {
                        $propertyName_id = $property['id_en'];
                    }
                    $productPropertiesTranslate = new ProductPropertiesTranslate();
                    $productPropertiesTranslate->product_properties_id = $productProperties->id;
                    $productPropertiesTranslate->language = $language;
                    $productPropertiesTranslate->value = '';
                    $productPropertiesTranslate->propertyName_id = $propertyName_id;
                    $productPropertiesTranslate->save();
                }
                Yii::$app->session->setFlash('info', 'Заповніть характеристики!');
            } else {
                dd($productProperties->errors);
            }
        }
    }

    private function createProductLayout($model)
    {
        $categoryProductLayout = Category::find()
            ->select([
                'product_keywords',
                'product_footer_description',
                'product_title',
                'product_description',
            ])
            ->where(['id' => $model->category_id])
            ->asArray()
            ->one();

        if ($categoryProductLayout) {
            $model->keywords = $categoryProductLayout['product_keywords'] ?? null;
            $model->footer_description = $categoryProductLayout['product_footer_description'] ?? null;
            $model->seo_title = $this->generateSeo($model->name, $categoryProductLayout['product_title']) ?? null;
            $model->seo_description = $this->generateSeo($model->name, $categoryProductLayout['product_description']) ?? null;

        } else {
            $model->keywords = null;
            $model->footer_description = null;
            $model->seo_title = null;
            $model->seo_description = null;
        }

    }

    private function generateSeo(string $name, ?string $template): ?string
    {
        if (!$template) {
            return null;
        }

        return str_replace('{name}', $name, $template);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public
    function actionUpdate($id)
    {
        $variants = ProductPackaging::find()
            ->alias('pp')
            ->select([
                'pp.id',
                'pp.product_variant_id',
                'pp.volume',
                'p.name',
            ])
            ->leftJoin('product p', 'p.id = pp.product_variant_id')
            ->where(['pp.product_id' => $id])
            ->asArray()
            ->all();

        $faq = Faq::find()
            ->alias('f')
            ->select([
                'f.id',
                'f.product_id',
                'f.question',
                'f.answer',
                'f.visible',
                'ft.question AS questionRu',
                'ft.answer AS answerRu',
            ])
            ->leftJoin('faq_translate ft', 'ft.faq_id = f.id')
            ->where(['f.product_id' => $id])
            ->asArray()
            ->all();

        $words = SeoWords::find()->where(['product_id' => $id])
            ->asArray()
            ->all();

        $model = $this->findModel($id);

        $translateRu = ProductsTranslate::findOne(['product_id' => $id, 'language' => 'ru']);

        $data = ProductProperties::find()
            ->alias('pp')
            ->select([
                'pp.id',
                'pp.property_id',
                'pp.category_id',
                'pp.value',
                'pn.name AS property_name',
            ])
            ->leftJoin(
                'properties_name pn',
                'pn.id = pp.property_id'
            )
            ->where(['pp.product_id' => $model->id])
            ->orderBy('pn.sort ASC')
            ->all();

        $propertiesId = [];
        foreach ($data as $datum) {
            $propertiesId[] = $datum->id;
        }

        $dataRu = ProductPropertiesTranslate::find()
            ->alias('ppt')
            ->select([
                'ppt.id',
                'ppt.value',
                'ppt.propertyName_id',
                'pnt.name AS property_name',
                'pn.sort',
            ])
            ->leftJoin(
                'properties_name_translate pnt',
                'pnt.id = ppt.propertyName_id'
            )
            ->leftJoin(
                'properties_name pn',
                'pn.id = pnt.name_id'
            )
            ->where(['ppt.product_properties_id' => $propertiesId])
            ->andWhere(['ppt.language' => 'ru'])
            ->orderBy('pn.sort ASC')
            ->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save(false)) {

            $postTranslates = $this->request->post('ProductsTranslate', []);
            $postPropertiesTranslate = $this->request->post('PropertiesTranslate', []);
            $postProperties = $this->request->post('ProductProperties', []);
            $post_priority = $this->request->post('priority');
            $post_product = $this->request->post('ProductsBackend', []);

            $this->updateTranslate($model->id, 'ru', $postTranslates['ru'] ?? null);

            $this->updateProperties($postProperties ?? null);

            $this->updateTranslateProperties($postPropertiesTranslate['ru'] ?? null);

            $this->updatePriorityImages($post_priority ?? null);

            $this->updateProductTags($model, $post_product ?? null);
            $this->updateProductAnalogs($model, $post_product ?? null);
            $this->updateProductGrups($model, $post_product ?? null);

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'data' => $data,
            'dataRu' => $dataRu,
            'translateRu' => $translateRu,
            'variants' => $variants,
            'faq' => $faq,
            'words' => $words,
        ]);
    }

    private
    function updateTranslate($productId, $language, $data)
    {
        if ($data) {
            $translate = ProductsTranslate::findOne(['product_id' => $productId, 'language' => $language]);
            if ($translate) {
                $translate->setAttributes($data);
                $translate->save();
            }
        }
    }

    private
    function updateTranslateProperties($data)
    {
        if ($data) {
            foreach ($data as $datum) {
                $translate = ProductPropertiesTranslate::find()
                    ->where(['id' => $datum['id']])
                    ->one();
                if ($translate) {
                    $translate->value = $datum['value'];
                    $translate->save();
                }
            }
        }
    }

    private
    function updateProperties($data)
    {
        if ($data) {
            foreach ($data as $postData) {
                $model = ProductProperties::find()->where(['id' => $postData['id']])->one();
                $model->value = $postData['value'];
                $model->save();
            }
        }
    }

    private
    function updatePriorityImages($data)
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $position = ProductImage::find()->where(['id' => $key])->one();
                $position->priority = $value;
                $position->save();
            }
        }
    }

    private
    function updateProductTags($model, $data)
    {
        if (!empty($data['tags'])) {
            $tags = ProductTag::find()->where(['product_id' => $model->id])->all();
            if ($tags) {
                foreach ($tags as $t) {
                    $t->delete();
                }
            }

            foreach ($data['tags'] as $tag_id) {
                $tag = ProductTag::find()
                    ->where(['product_id' => $model->id])
                    ->andWhere(['tag_id' => $tag_id])
                    ->one();
                if (!$tag) {
                    $add_tag = new ProductTag();
                    $add_tag->product_id = $model->id;
                    $add_tag->tag_id = $tag_id;
                    $add_tag->save();
                }
            }
        }
    }

    private
    function updateProductAnalogs($model, $data)
    {
        if (!empty($data['analogs'])) {
            $analogs = AnalogProducts::find()->where(['product_id' => $model->id])->all();
            if ($analogs) {
                foreach ($analogs as $analog) {
                    $analog->delete();
                }
            }
            $analogs = AnalogProducts::find()->where(['analog_product_id' => $model->id])->all();
            if ($analogs) {
                foreach ($analogs as $analog) {
                    $analog->delete();
                }
            }

            foreach ($data['analogs'] as $analog_id) {
                if ($model->id != $analog_id) {
                    $analogToProduct = AnalogProducts::find()
                        ->where(['product_id' => $model->id])
                        ->andWhere(['analog_product_id' => $analog_id])
                        ->one();

                    if (!$analogToProduct) {
                        $add_analog_to_product = new AnalogProducts();
                        $add_analog_to_product->product_id = $model->id;
                        $add_analog_to_product->analog_product_id = $analog_id;
                        $add_analog_to_product->save();
                    }
                }

                if ($model->id != $analog_id) {
                    $productToAnalog = AnalogProducts::find()
                        ->where(['product_id' => $analog_id])
                        ->andWhere(['analog_product_id' => $model->id])
                        ->one();

                    if (!$productToAnalog) {
                        $add_product_to_analog = new AnalogProducts();
                        $add_product_to_analog->product_id = $analog_id;
                        $add_product_to_analog->analog_product_id = $model->id;
                        $add_product_to_analog->save();
                    }
                }

                foreach ($data['analogs'] as $other_analog_id) {
                    if ($analog_id != $other_analog_id && $analog_id != $model->id && $other_analog_id != $model->id) {
                        $analogToOtherAnalog = AnalogProducts::find()
                            ->where(['product_id' => $analog_id])
                            ->andWhere(['analog_product_id' => $other_analog_id])
                            ->one();

                        if (!$analogToOtherAnalog) {
                            $add_analog_to_other_analog = new AnalogProducts();
                            $add_analog_to_other_analog->product_id = $analog_id;
                            $add_analog_to_other_analog->analog_product_id = $other_analog_id;
                            $add_analog_to_other_analog->save();
                        }

                        $otherAnalogToAnalog = AnalogProducts::find()
                            ->where(['product_id' => $other_analog_id])
                            ->andWhere(['analog_product_id' => $analog_id])
                            ->one();

                        if (!$otherAnalogToAnalog) {
                            $add_other_analog_to_analog = new AnalogProducts();
                            $add_other_analog_to_analog->product_id = $other_analog_id;
                            $add_other_analog_to_analog->analog_product_id = $analog_id;
                            $add_other_analog_to_analog->save();
                        }
                    }
                }
            }
        }
    }

    private
    function updateProductGrups($model, $data)
    {
        if (!empty($data['grups'])) {
            $grups = ProductGrup::find()->where(['product_id' => $model->id])->all();
            if ($grups) {
                foreach ($grups as $g) {
                    $g->delete();
                }
            }
            foreach ($data['grups'] as $grup_id) {
                $grup = ProductGrup::find()
                    ->where(['product_id' => $model->id])
                    ->andWhere(['grup_id' => $grup_id])
                    ->one();
                if (!$grup) {
                    $add_grup = new ProductGrup();
                    $add_grup->product_id = $model->id;
                    $add_grup->grup_id = $grup_id;
                    $add_grup->save();
                }
            }
        } else {
            $grups = ProductGrup::find()->where(['product_id' => $model->id])->all();
            if ($grups) {
                foreach ($grups as $g) {
                    $g->delete();
                }
            }
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public
    function actionDelete($id)
    {
        $dir = Yii::getAlias('@frontendWeb/product/');
        $model = $this->findModel($id);
        $properties = ProductProperties::find()->where(['product_id' => $model->id])->all();

        $propertyId = [];
        foreach ($properties as $property) {
            $propertyId[] = $property->id;
        }

        $propertiesTranslate = ProductPropertiesTranslate::find()->where(['product_properties_id' => $propertyId])->all();
        $images = ProductImage::find()->where(['product_id' => $model->id])->all();
        $tags = ProductTag::find()->where(['product_id' => $model->id])->all();
        $grups = ProductGrup::find()->where(['product_id' => $model->id])->all();
        $analogs = AnalogProducts::find()->where(['product_id' => $model->id])->all();
        $productTranslate = ProductsTranslate::find()->where(['product_id' => $model->id])->all();
        foreach ($images as $image) {
            //----------- Удаление всех картинок продукта
            (file_exists($dir . $image->name)) ? unlink($dir . $image->name) : '';
            (file_exists($dir . $image->extra_extra_large)) ? unlink($dir . $image->extra_extra_large) : '';
            (file_exists($dir . $image->extra_large)) ? unlink($dir . $image->extra_large) : '';
            (file_exists($dir . $image->large)) ? unlink($dir . $image->large) : '';
            (file_exists($dir . $image->medium)) ? unlink($dir . $image->medium) : '';
            (file_exists($dir . $image->small)) ? unlink($dir . $image->small) : '';
            (file_exists($dir . $image->extra_small)) ? unlink($dir . $image->extra_small) : '';
            //----------- Удаление каталога продукта
            $files = scandir($dir . $model->id);
            $files = array_diff($files, array('.', '..'));
            (is_dir($dir . $model->id) && empty($files)) ? FileHelper::removeDirectory($dir . $model->id) : '';

            $image->delete();
        }
        foreach ($tags as $tag) {
            $tag->delete();
        }

        foreach ($grups as $grup) {
            $grup->delete();
        }

        foreach ($analogs as $analog) {
            $analog->delete();
        }

        foreach ($productTranslate as $translate) {
            $translate->delete();
        }

        foreach ($properties as $property) {
            $property->delete();
        }

        foreach ($propertiesTranslate as $property) {
            $property->delete();
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ProductsBackend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = ProductsBackend::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public
    function actionCreateImage($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $model = ProductsBackend::find()->where(['id' => $id])->one();
        $imageModel = new ProductImage();
        $imageModel->product_id = $id;

        if ($request->isAjax) {
            if ($request->isGet) {
                return [
                    'title' => "Додавання зображення: " . $model->name,
                    'content' => $this->renderAjax('create-image', [
                        'imageModel' => $imageModel,
                    ]),
                ];
            } else if ($imageModel->load($request->post()) && $imageModel->save()) {
                return [
                    'forceReload' => '#images-table',
                ];
            }
        }
    }

    public
    function actionAjaxUpload($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $stock = ProductsBackend::findOne($id);
        if (!$stock) {
            return ['error' => 'Product not found.'];
        }

        $directory = $stock->id;
        $dir = Yii::getAlias('@frontendWeb/product/');
        $model = new ProductImage();

        if (!Yii::$app->request->isAjax || !$model->validate()) {
            return ['error' => 'Invalid request or data validation failed.'];
        }

        if (!file_exists($dir . $directory)) {
            mkdir($dir . $directory, 0777, true);
        }

        $allowedExtensions = ['jpg', 'gif', 'png', 'jpeg'];
        $sizes = [
            'extra_extra_large' => 350,
            'extra_large' => 290,
            'large' => 195,
            'medium' => 150,
            'small' => 90,
            'extra_small' => 64,
        ];

        foreach (UploadedFile::getInstances($model, 'name') as $file) {
            $imageName = $stock->slug . '-' . uniqid();

            if (!in_array($file->extension, $allowedExtensions)) {
                $file->saveAs("{$dir}{$directory}/{$imageName}.{$file->extension}");
                continue;
            }

            $tempImagePath = "{$dir}{$directory}/temp-{$imageName}.{$file->extension}";
            $file->saveAs($tempImagePath);

            $originalImagePath = "{$dir}{$directory}/{$imageName}.{$file->extension}";
            $originalWebpPath = "{$dir}{$directory}/{$imageName}.webp";

            // Создаем основное изображение
            Image::resize($tempImagePath, 700, 700)->save($originalImagePath, ['quality' => 80]);
            Image::resize($tempImagePath, 700, 700)->save($originalWebpPath, ['quality' => 80]);

            // Генерируем изображения разных размеров
            foreach ($sizes as $sizeName => $size) {
                $imagePath = "{$dir}{$directory}/{$sizeName}-{$imageName}.{$file->extension}";
                $webpPath = "{$dir}{$directory}/{$sizeName}-{$imageName}.webp";

                Image::resize($tempImagePath, $size, $size)->save($imagePath, ['quality' => 70]);
                Image::resize($tempImagePath, $size, $size)->save($webpPath, ['quality' => 70]);
            }

            // Удаляем временный файл
            unlink($tempImagePath);

            // Сохраняем данные в базу
            $model->product_id = $id;
            $model->name = "{$directory}/{$imageName}.{$file->extension}";
            $model->webp_name = "{$directory}/{$imageName}.webp";

            foreach ($sizes as $sizeKey => $size) {
                $model->{$sizeKey} = "{$directory}/{$sizeKey}-{$imageName}.{$file->extension}";
                $model->{"webp_{$sizeKey}"} = "{$directory}/{$sizeKey}-{$imageName}.webp";
            }

            if ($model->save()) {
                Yii::$app->getSession()->addFlash('success', "Файл: {$model->name} успешно добавлен");
            }
        }

        return ['success' => true];
    }

    public
    function actionRemoveImage($id)
    {
        $image = ProductImage::find()->where(['id' => $id])->one();

        $dir = Yii::getAlias('@frontendWeb/product/');
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            //----------- Удаление основной картинки и нарезаных
            (file_exists($dir . $image->name)) ? unlink($dir . $image->name) : '';
            (file_exists($dir . $image->extra_extra_large)) ? unlink($dir . $image->extra_extra_large) : '';
            (file_exists($dir . $image->extra_large)) ? unlink($dir . $image->extra_large) : '';
            (file_exists($dir . $image->large)) ? unlink($dir . $image->large) : '';
            (file_exists($dir . $image->medium)) ? unlink($dir . $image->medium) : '';
            (file_exists($dir . $image->small)) ? unlink($dir . $image->small) : '';
            (file_exists($dir . $image->extra_small)) ? unlink($dir . $image->extra_small) : '';

            (file_exists($dir . $image->webp_name)) ? unlink($dir . $image->webp_name) : '';
            (file_exists($dir . $image->webp_extra_extra_large)) ? unlink($dir . $image->webp_extra_extra_large) : '';
            (file_exists($dir . $image->webp_extra_large)) ? unlink($dir . $image->webp_extra_large) : '';
            (file_exists($dir . $image->webp_large)) ? unlink($dir . $image->webp_large) : '';
            (file_exists($dir . $image->webp_medium)) ? unlink($dir . $image->webp_medium) : '';
            (file_exists($dir . $image->webp_small)) ? unlink($dir . $image->webp_small) : '';
            (file_exists($dir . $image->webp_extra_small)) ? unlink($dir . $image->webp_extra_small) : '';

            if ($image->delete()) {
                return true;
            }
        }
    }

    public
    function actionExportToExcel()
    {
        $products = ProductsBackend::find()->all();

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Название');
        $sheet->setCellValue('B1', 'Цена');
        $sheet->setCellValue('C1', 'Ст. Цена');
        $sheet->setCellValue('D1', 'Наличие');
        $sheet->setCellValue('E1', 'ID');

        $cellStyleAE = $sheet->getStyle('A1:E1');
        $cellStyleAE->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(5);

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '92d050', // Зеленый цвет
                ],
            ],
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($styleArray);
        $sheet->getStyle('A1:E1')->getFont()->setSize(14); // Установите размер шрифта

        $row = 2; // начнем с второй строки
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product->name);
            $sheet->setCellValue('B' . $row, $product->price);
            $sheet->setCellValue('C' . $row, $product->old_price);
            $sheet->setCellValue('D' . $row, $product->status->name);
            $sheet->setCellValue('E' . $row, $product->id);

            $cellStyleAll = $sheet->getStyle('A' . $row . ':E' . $row);

            if ($product->status_id == 1) {
                $cellStyleAll->getFill()->setFillType(Fill::FILL_SOLID);
                $cellStyleAll->getFill()->getStartColor()->setRGB('d8e4bc');
            } elseif ($product->status_id == 2) {
                $cellStyleAll->getFill()->setFillType(Fill::FILL_SOLID);
                $cellStyleAll->getFill()->getStartColor()->setRGB('e6b8b7');
            } elseif ($product->status_id == 3) {
                $cellStyleAll->getFill()->setFillType(Fill::FILL_SOLID);
                $cellStyleAll->getFill()->getStartColor()->setRGB('fde9d9');
            } elseif ($product->status_id == 4) {
                $cellStyleAll->getFill()->setFillType(Fill::FILL_SOLID);
                $cellStyleAll->getFill()->getStartColor()->setRGB('b7dee8');
            }

            $cellStyleAll->getFont()->setSize(12);

            $cellStyleAll->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $cellStyleBE = $sheet->getStyle('B' . $row . ':E' . $row);

            $cellStyleBE->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
        }

        ob_start();

        try {
            $writer = new Xlsx($spreadsheet);
            $file_name = 'agro_pro_products__' . date('d_m_Y', time()) . '.xlsx';

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

    public
    function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');
            $filePath = $model->upload();
            if (file_exists($filePath)) {
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $data = $worksheet->toArray();
                unlink($filePath);
                $headers = array_shift($data);
                $resultArray = [];
                foreach ($data as $row) {
                    $resultArray[] = array_combine($headers, $row);
                }
                foreach ($resultArray as $item) {
                    if ($item['Цена'] != null && is_numeric($item['Цена'])) {
                        $product = ProductsBackend::find()
                            ->select(['id', 'name', 'price'])
                            ->where(['id' => $item['ID']])
                            ->one();

                        $product->price = $item['Цена'];
                        $product->old_price = $item['Ст. Цена'];

                        if ($product->save(false)) {

                        } else {
                            print_r($product->errors);
                        }
                    } else {
                        echo "Есть не заполненая цена";
                    }
                }
            } else {
                echo 'Файл не существует.';
            }
            return $this->redirect(['index']);
        }
        return $this->render('upload', ['model' => $model]);
    }

    public
    function actionUpdateErrorCheckbox()
    {
        if (Yii::$app->request->isPost) {
            $errors = Yii::$app->request->post('errorsSeo');
            Yii::$app->session->set('errorsSeo', $errors);
            return $this->asJson(['success' => true]);
        }
        return $this->asJson(['success' => false]);
    }

    public
    function actionClearSearchParams()
    {
        Yii::$app->session->remove('product_search_params');
        return $this->redirect(['index']);
    }

    public
    function actionTranslateProperties()
    {
        if (Yii::$app->request->isPost) {
            $properties = Yii::$app->request->post('properties');

            $translations = [];
            foreach ($properties as $property) {
                $translatedValue = $this->translateToRussian($property['value']);
                $translations[] = $translatedValue;
            }

            return $this->asJson([
                'success' => true,
                'translations' => $translations
            ]);
        }

        return $this->asJson(['success' => false]);
    }

    private
    function translateToRussian($text)
    {
        $language = 'ru'; // Языки перевода

        $tr = new GoogleTranslate();
        $tr->setSource();
        $tr->setOptions([
            'model' => 'nmt', // 'nmt' (нейросеть) или 'base' (обычный перевод)
        ]);
        $tr->setTarget($language);

        return $tr->translate($text);
    }

    public
    function actionAddProductVariants()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->getRawBody();  // Получаем сырые данные

            // Декодируем JSON
            $data = json_decode($data, true);

            // Проверяем наличие данных
            if (isset($data['productId'], $data['variantId'], $data['volume'])) {

                $productId = $data['productId'];
                $variantId = $data['variantId'];
                $productVolume = $data['productVolume'];
                $volume = $data['volume'];

                $model = new ProductPackaging();
                $model->product_id = $productId;
                $model->product_variant_id = $variantId;
                $model->volume = $volume;
                if ($model->save()) {
                    $productVariant = ProductPackaging::find()
                        ->where(['product_id' => $variantId])
                        ->andWhere(['product_variant_id' => $productId])
                        ->count();
                    if ($productVariant === 0) {
                        $model = new ProductPackaging();
                        $model->product_id = $variantId;
                        $model->product_variant_id = $productId;
                        $model->volume = $productVolume;
                        $model->save();
                    }
                }

                $variants = ProductPackaging::find()
                    ->alias('pp')
                    ->select([
                        'pp.id',
                        'pp.product_variant_id',
                        'pp.volume',
                        'p.name',
                    ])
                    ->leftJoin('product p', 'p.id = pp.product_variant_id')
                    ->where(['pp.product_id' => $productId])
                    ->asArray()
                    ->all();

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'variants' => $this->renderPartial('sidebar/_variant-table', ['variants' => $variants, 'id' => $productId]), // Рендерим частичную таблицу
                ];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => false, 'error' => 'Не всі дані передані контроллер.'];
            }
        }
        throw new BadRequestHttpException('Некоректний запит.');
    }

    function actionRemoveVariant($id)
    {
        $word = ProductPackaging::find()->where(['id' => $id])->one();
        {
            if ($word->delete()) {
                return true;
            }
        }
    }

    public
    function actionAddProductFaq()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->getRawBody();  // Получаем сырые данные

            // Декодируем JSON
            $data = json_decode($data, true);

            // Проверяем наличие данных
            if (isset($data['productId'], $data['question'], $data['questionRu'], $data['answer'], $data['answerRu'])) {

                $productId = $data['productId'];
                $question = $data['question'];
                $question_ru = $data['questionRu'];
                $answer = $data['answer'];
                $answer_ru = $data['answerRu'];

                $model = new Faq();
                $model->product_id = $productId;
                $model->question = $question;
                $model->answer = $answer;
                $model->visible = 0;
                if ($model->save()) {
                    $modelRu = new FaqTranslate();
                    $modelRu->faq_id = $model->id;
                    $modelRu->language = 'ru';
                    $modelRu->question = $question_ru;
                    $modelRu->answer = $answer_ru;
                    $modelRu->save();
                }


                $faq = Faq::find()
                    ->alias('f')
                    ->select([
                        'f.id',
                        'f.product_id',
                        'f.question',
                        'f.answer',
                        'f.visible',
                        'ft.question AS questionRu',
                        'ft.answer AS answerRu',
                    ])
                    ->leftJoin('faq_translate ft', 'ft.faq_id = f.id')
                    ->where(['f.product_id' => $productId])
                    ->asArray()
                    ->all();


                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'faq' => $this->renderPartial('_faq-table', ['faq' => $faq, 'id' => $productId]), // Рендерим частичную таблицу
                ];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => false, 'error' => 'Не всі дані передані контроллер.'];
            }
        }
        throw new BadRequestHttpException('Некоректний запит.');
    }

    public
    function actionEditProductFaq()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->getRawBody();  // Получаем сырые данные

            // Декодируем JSON
            $data = json_decode($data, true);

            // Проверяем наличие данных
            if (isset($data['id'], $data['productId'], $data['question'], $data['questionRu'], $data['answer'], $data['answerRu'])) {
                $id = $data['id'];
                $productId = $data['productId'];
                $question = $data['question'];
                $question_ru = $data['questionRu'];
                $answer = $data['answer'];
                $answer_ru = $data['answerRu'];


                $model = Faq::find()->where(['id' => $id])->one();
                $model->question = $question;
                $model->answer = $answer;
                if ($model->save()) {
                    $modelRu = FaqTranslate::find()->where(['faq_id' => $id])->one();
                    $modelRu->question = $question_ru;
                    $modelRu->answer = $answer_ru;
                    $modelRu->save();
                }

                $faq = Faq::find()
                    ->alias('f')
                    ->select([
                        'f.id',
                        'f.product_id',
                        'f.question',
                        'f.answer',
                        'f.visible',
                        'ft.question AS questionRu',
                        'ft.answer AS answerRu',
                    ])
                    ->leftJoin('faq_translate ft', 'ft.faq_id = f.id')
                    ->where(['f.product_id' => $productId])
                    ->asArray()
                    ->all();


                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'faq' => $this->renderPartial('_faq-table', ['faq' => $faq, 'id' => $productId]), // Рендерим частичную таблицу
                ];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => false, 'error' => 'Не всі дані передані контроллер.'];
            }
        }
        throw new BadRequestHttpException('Некоректний запит.');
    }

    public function actionDeleteProductFaq()
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

        $model = Faq::findOne($id);
        if ($model && $model->delete()) {
            $modelRu = FaqTranslate::findOne(['faq_id' => $id]);
            if ($modelRu) {
                $modelRu->delete();
            }
        }

        $faq = Faq::find()
            ->alias('f')
            ->select([
                'f.id',
                'f.product_id',
                'f.question',
                'f.answer',
                'f.visible',
                'ft.question AS questionRu',
                'ft.answer AS answerRu',
            ])
            ->leftJoin('faq_translate ft', 'ft.faq_id = f.id')
            ->where(['f.product_id' => $productId])
            ->asArray()
            ->all();

        return [
            'success' => true,
            'faq' => $this->renderPartial('_faq-table', ['faq' => $faq, 'id' => $productId]),
        ];
    }

    public function actionUpdateCheckboxFaq()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException('Некорректный запрос.');
        }

        $id = Yii::$app->request->post('id');
        $state = Yii::$app->request->post('state');
        $productId = Yii::$app->request->post('productId');

        if (!$id || $state === null) {
            return ['success' => false, 'error' => 'Недостаточно данных.'];
        }

        $model = Faq::findOne($id);
        $model->visible = $state;
        $model->save();

        $faq = Faq::find()
            ->alias('f')
            ->select([
                'f.id',
                'f.product_id',
                'f.question',
                'f.answer',
                'f.visible',
                'ft.question AS questionRu',
                'ft.answer AS answerRu',
            ])
            ->leftJoin('faq_translate ft', 'ft.faq_id = f.id')
            ->where(['f.product_id' => $productId])
            ->asArray()
            ->all();

        return [
            'success' => true,
            'newState' => $state,
            'faq' => $this->renderPartial('_faq-table', ['faq' => $faq, 'id' => $productId]),
        ];
    }

    public
    function actionAddWords()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->getRawBody();  // Получаем сырые данные

            // Декодируем JSON
            $data = json_decode($data, true);

            // Проверяем наличие данных
            if (isset($data['productId'], $data['categoryId'], $data['wordUk'], $data['wordRu'])) {


                $model = new SeoWords();
                $model->product_id = $data['productId'];
                $model->category_id = $data['categoryId'];
                $model->uk_word = $data['wordUk'];
                $model->ru_word = $data['wordRu'];
//                $model->visible = 0;
                $model->save();



                $words = SeoWords::find()
                    ->where(['product_id' => $data['productId']])
                    ->asArray()
                    ->all();

                $model = ProductsBackend::findOne($data['productId']);

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'words' => $this->renderPartial('sidebar/_words-table', [
                        'words' => $words,
                        'id' => $data['productId'],
                        'model' => $model,
                    ]),
                ];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => false, 'error' => 'Не всі дані передані контроллер.'];
            }

        }
        throw new BadRequestHttpException('Некоректний запит.');
    }

    function actionRemoveWord($id)
    {
        $word = SeoWords::find()->where(['id' => $id])->one();
        {
            if ($word->delete()) {
                return true;
            }
        }
    }

}
