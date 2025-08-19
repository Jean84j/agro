<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\Category;
use common\models\shop\ProductTag;
use common\models\shop\Product;
use common\models\shop\Tag;
use Yii;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

class TagController extends BaseFrontendController
{
    public function actionIndex()
    {
        $language = Yii::$app->language;

        $categoriesTags = [];
        $categories = Category::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.slug',
                'IFNULL(ct.name, c.name) AS name',
            ])
            ->innerJoin(Product::tableName() . ' p', 'p.category_id = c.id')
            ->leftJoin(
                'categories_translate ct',
                'ct.category_id = c.id AND ct.language = :language',
                [':language' => $language]
            )
            ->where(['c.visibility' => true])
            ->distinct()
            ->all();

        foreach ($categories as $category) {
            $tags = Tag::find()
                ->alias('t')
                ->select([
                    't.id',
                    't.slug',
                    'IFNULL(tt.name, t.name) AS name', // Используем перевод, если он доступен
                ])
                ->innerJoin(ProductTag::tableName() . ' pt', 'pt.tag_id = t.id')
                ->innerJoin(Product::tableName() . ' p', 'p.id = pt.product_id')
                ->leftJoin(
                    'tag_translate tt', // Таблица переводов
                    'tt.tag_id = t.id AND tt.language = :language', // Привязка к текущему языку
                    [':language' => $language]
                )
                ->where(['p.category_id' => $category->id, 't.visibility' => true])
                ->distinct()
                ->all();

            if ($tags) {
                $categoriesTags[] = [
                    'category' => $category,
                    'tags' => $tags,
                ];
            }
        }

        $seo = Settings::seoPageTranslate('tag');
        $type = 'website';
        $title = $seo->title;
        $description = $seo->description;
        $image = '';
        $keywords = '';
        Settings::setMetamaster($type, $title, $description, $image, $keywords);

        $page_description = $seo->page_description;

        return $this->render('index',
            [
                'categories' => $categoriesTags,
                'page_description' => $page_description,
            ]);
    }

    public function actionView($slug, $category_slug = null)
    {
        $language = Yii::$app->session->get('_language');

        $categoryName = '';

        $params = $this->setSortAndCount();
        $sort = $params['sort'];
        $count = $params['count'];

        $tag_name = Tag::find()->where(['slug' => $slug])->one();

        if ($tag_name === null) {
            throw new NotFoundHttpException('Tag not found ' . '" ' . $slug . ' "');
        }

        if ($category_slug) {
            $category = Category::find()
                ->alias('c')
                ->select([
                    'c.id',
                    'c.slug',
                    'IFNULL(ct.name, c.name) AS name',
                ])
                ->leftJoin(
                    'categories_translate ct', // Таблица переводов
                    'ct.category_id = c.id AND ct.language = :language'
                )
                ->where(['c.slug' => $category_slug])
                ->addParams([':language' => $language])
                ->one();

            $categoryId = $category->id;
            $categoryName = Yii::t('app', 'в категорії ') . '<span style="color: #90998cc7">' . $category->name . '</span>';
            $tags = ProductTag::find()
                ->alias('pt')
                ->innerJoin(Product::tableName() . ' p', 'pt.product_id = p.id')
                ->where(['p.category_id' => $categoryId, 'pt.tag_id' => $tag_name->id])
                ->all();

        } else {
            $tags = ProductTag::find()->where(['tag_id' => $tag_name->id])->all();
        }

        $categories = Category::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.slug',
                'IFNULL(ct.name, c.name) AS name',
                'IFNULL(ct.description, c.description) AS description',
                'IFNULL(ct.pageTitle, c.pageTitle) AS pageTitle',
                'IFNULL(ct.metaDescription, c.metaDescription) AS metaDescription',
            ])
            ->innerJoin(Product::tableName() . ' p', 'p.category_id = c.id')
            ->innerJoin(ProductTag::tableName() . ' pt', 'pt.product_id = p.id')
            ->leftJoin(
                'categories_translate ct', // Таблица переводов
                'ct.category_id = c.id AND ct.language = :language'
            )
            ->where(['pt.tag_id' => $tag_name->id])
            ->addParams([':language' => $language]) // Передача параметра языка
            ->distinct()
            ->all();

        $query = Product::find()
            ->alias('p')
            ->select([
                'p.id',
                'p.name',
                'p.slug',
                'p.price',
                'p.old_price',
                'p.status_id',
                'p.label_id',
                'p.currency',
                'IFNULL(pt.name, p.name) AS name', // Переведенное или оригинальное название продукта
                'p.category_id', // id категории
                'c.name AS category_name', // Название категории
                'IFNULL(ct.name, c.name) AS category_translated_name', // Переведенное или оригинальное название категории
                'IFNULL(ct.prefix, c.prefix) AS category_translated_prefix' // Переведенный или оригинальный префикс категории
            ])
            ->leftJoin(
                'products_translate pt', // Таблица переводов для продуктов
                'pt.product_id = p.id AND pt.language = :language'
            )
            ->leftJoin(
                'category c', // Присоединяем таблицу категорий
                'c.id = p.category_id' // Присоединяем по id категории
            )
            ->leftJoin(
                'status s', // Присоединяем таблицу категорий
                's.id = p.status_id' // Присоединяем по id категории
            )
            ->leftJoin(
                'categories_translate ct', // Таблица переводов для категорий
                'ct.category_id = c.id AND ct.language = :language'
            )
            ->where(['p.id' => array_column($tags, 'product_id')])
            ->addParams([':language' => $language]);

        $this->applySorting($query, $sort);

        $pages = $this->setPagination($query, $count);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $products_all = $query->count();

        if ($language !== 'uk') {
            foreach ($products as $product) {
                $translationCat = $product->category->getTranslation($language)->one();
                if ($translationCat) {
                    if ($translationCat->prefix) {
                        $product->category->prefix = $translationCat->prefix;
                    }
                }
            }
        }

        $this->setProductMetadata($tag_name, $language);

        return $this->render('view',
            [
                'products' => $products,
                'categories' => $categories,
                'products_all' => $products_all,
                'tag_name' => $tag_name,
                'pages' => $pages,
                'language' => $language,
                'categoryName' => $categoryName,
            ]);

    }

    public function actionRedirect($id)
    {
        $tag = Tag::findOne($id);
        if (!$tag) {
            throw new NotFoundHttpException("Tag not found id = " . $id);
        }
        $newUrl = Url::to(['tag/view', 'slug' => $tag->slug], true);

        return $this->redirect($newUrl, 301);
    }

    protected function setProductMetadata($tag_name, $language)
    {
        if ($tag_name->seo_title) {
            $title = $tag_name->getTagSeoTitleTranslate($tag_name, $language);
        } else {
            $title = 'Продукти які відповідають запиту ' . '[ ' . $tag_name->getTagTranslate($tag_name, $language) . ' ]';
        }
        if ($tag_name->seo_description) {
            $description = $tag_name->getTagSeoDescriptionTranslate($tag_name, $language);
        } else {
            $description = 'На сторінці відображено товари які згруповані запитом ' . '[ ' . $tag_name->getTagTranslate($tag_name, $language) . ' ]';

        }

        Yii::$app->metamaster
            ->setType('website')
            ->setUrl(Url::canonical())
            ->setTitle($title)
            ->setDescription($description)
            ->register(Yii::$app->getView());
    }
}