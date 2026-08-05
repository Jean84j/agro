<?php

namespace frontend\controllers;

use common\models\Posts;
use common\models\Settings;
use Spatie\SchemaOrg\Schema;
use yii\helpers\Url;
use yii\i18n\Formatter;
use Yii;

class BlogsController extends BaseFrontendController
{
    public function actionView($q = null)
    {
        $language = Yii::$app->language;

        $count = 4;

        $posts = Posts::find()->all();

        if ($language !== 'uk') {
            $this->getPostTranslation($posts, $language);
        }

        if ($q == null) {
            $query = Posts::find();
        } else {

            $query = Posts::find()->where(['like', 'title', $q])->orWhere(['like', 'description', $q]);

            if ($query->count() == 0) {
                $query = Posts::find();
            }
        }

        $pages = $this->setPagination($query, $count);
        $blogs = $query->offset($pages->offset)->limit($pages->limit)->orderBy('date_public DESC')->all();

        if ($language !== 'uk') {
            $this->getPostTranslation($blogs, $language);
        }

        $seo = Settings::seoPageTranslate('blogs');

        Yii::$app->metamaster
            ->setIndexable(true)
            ->setType('website')
            ->setTitle($seo->title)
            ->setDescription(strip_tags($seo->description))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
            ->setImage('/images/og_img/blogs_page.webp')
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

        $files = $this->getRelativeFiles('@webroot/images/blogs');

        $this->getSchemaBlogs($posts, $seo->description);

        return $this->render('view',
            [
                'blogs' => $blogs,
                'pages' => $pages,
                'page_description' => $seo->page_description,
                'files' => $files,
            ]);
    }

    protected function getPostTranslation($posts, $language)
    {
        foreach ($posts as $postItem) {
            if ($postItem) {
                $translationPost = $postItem->getTranslation($language)->one();
                if ($translationPost) {
                    if ($translationPost->title) {
                        $postItem->title = $translationPost->title;
                    }
                    if ($translationPost->description) {
                        $postItem->description = $translationPost->description;
                    }
                }
            }
        }
    }

    protected function getSchemaBlogs($posts, $description)
    {
        $language = Yii::$app->language;
        $formatter = new Formatter();

        $host = Yii::$app->request->hostInfo;
        if ($language !== 'uk') {
            $host .= '/ru';
        }

        $blogPosts = [];

        foreach ($posts as $post) {

            $text = trim(strip_tags($post->description));

            if (mb_strlen($text) > 200) {
                $text = mb_substr($text, 0, 197) . '...';
            }

            $url = $host . '/post/' . $post->slug;
            $image = Yii::$app->request->hostInfo . '/posts/' . $post->image;

            $blogPosts[] = Schema::blogPosting()
                ->headline($post->title)
                ->description($post->seo_description ?: $text)
                ->articleBody($text)
                ->articleSection($post->category->name ?? null)
                ->datePublished($formatter->asDatetime($post->date_public, 'php:c'))
                ->dateModified($formatter->asDatetime($post->date_updated ?? $post->date_public, 'php:c'))
                ->url($url)
                ->mainEntityOfPage(
                    Schema::webPage()
                        ->id($url)
                )
                ->image(
                    Schema::imageObject()
                        ->url($image)
                )
                ->author(
                    Schema::organization()
                        ->name('AgroPro')
                        ->url($host)
                )
                ->publisher(
                    Schema::organization()
                        ->name('AgroPro')
                        ->url($host)
                        ->logo(
                            Schema::imageObject()
                                ->url(Yii::$app->request->hostInfo . '/images/logos/meta_logo.jpg')
                        )
                );
        }

        $schemaBlog = Schema::blog()
            ->name('Блог AgroPro')
            ->url($host . '/blogs')
            ->description($description)
            ->blogPosts($blogPosts);

        Yii::$app->params['blog'] = $schemaBlog->toScript();
    }

}