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

        $this->getSchemaBlogs($posts);

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
        $type = 'website';
        $url = Url::canonical();
        $title = $seo->title;
        $description = $seo->description;
        $image = '';
        $keywords = '';
        $alternateUrls = $this->getAlternateUrl();
        Settings::setMetamaster($type, $title, $description, $image, $keywords, $url, $alternateUrls);

        $files = $this->getRelativeFiles('@webroot/images/blogs');

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

    protected function getSchemaBlogs($posts)
    {
        $language = Yii::$app->language;
        $blogPosting = [];
        $formatter = new Formatter;
        $host = Yii::$app->request->hostInfo;

        if ($language != 'uk') {
            $host = $host . '/ru';
        }

        foreach ($posts as $post) {
            $blogPost = [
                "@type" => "BlogPosting",
                "headline" => $post->title,
                "articleBody" => mb_strlen(strip_tags($post->description)) > 500
                    ? mb_substr(strip_tags($post->description), 0, 497) . '...'
                    : strip_tags($post->description),
                "articleSection" => $post->category->name ?? null,
                "datePublished" => $formatter->asDatetime($post->date_public, 'php:Y-m-d\TH:i:sP'),
                "dateModified" => $formatter->asDatetime($post->date_updated ?? $post->date_public, 'php:Y-m-d\TH:i:sP'),
                "url" => $host . '/post/' . $post->slug,
                "image" => [
                    Yii::$app->request->hostInfo . '/posts/' . $post->image
                ],
                "author" => [
                    "@type" => "Person",
                    "name" => "AgroPro",
                    "url" => $host
                ],
                "publisher" => [
                    "@type" => "Organization",
                    "name" => "AgroPro",
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => Yii::$app->request->hostInfo . '/logos/meta_logo.jpg'
                    ]
                ]
            ];

            $blogPosting[] = $blogPost;
        }

        $schemaBlog = Schema::Blog()
            ->blogPosts($blogPosting);

        Yii::$app->params['blog'] = $schemaBlog->toScript();
    }

}