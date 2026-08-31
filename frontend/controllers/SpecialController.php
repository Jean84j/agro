<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\Product;
use Spatie\SchemaOrg\Schema;
use Yii;
use yii\db\Expression;
use yii\helpers\Url;

class SpecialController extends BaseFrontendController
{
    public function actionView()
    {
        $language = Yii::$app->language;
        $layout = Yii::$app->session->get('selectedLayout', 'grid-3-sidebar');

        $params = $this->setSortAndCount();
        $sort = $params['sort'];
        $count = $params['count'];

        $query = Product::find()
            ->andWhere(['not', ['label_id' => null]])
            ->orderBy([
                new Expression('FIELD(status_id, 1, 3, 4, 2)')
            ]);

        $this->applySorting($query, $sort);

        $pages = $this->setPagination($query, $count);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $products_all = $query->count();

        if ($language !== 'uk') {
            $products = $this->translateProducts($products, $language);
        }

        $seo = Settings::seoPageTranslate('special');

        $url = Url::canonical();
        $title = $seo->title;
        $description = $seo->description;
        $image = '';

        Yii::$app->metamaster
            ->setIndexable(true)
            ->setType('website')
            ->setTitle($seo->title)
            ->setDescription(strip_tags($seo->description))
            ->setUrl(Url::canonical())
            ->setAlternateUrls($this->getAlternateUrl())
            ->setImage('/images/og_img/special_page.webp')
//            ->setKeywords('')
//            ->setPrice('')
            ->register(Yii::$app->view);

        $page_description = $seo->page_description;

        $this->setSpecialSchema($title, $description, $image, $url);

        $files = $this->getRelativeFiles('@webroot/images/block-images/special');

        return $this->render('view', compact([
            'products',
            'products_all',
            'pages',
            'language',
            'page_description',
            'files',
            'layout'
        ]));
    }

    protected function setSpecialSchema($title, $description, $image, $url)
    {
        $special = Schema::collectionPage()
            ->name($title)
            ->description($description)
            ->url($url)
            ->image($image)
            ->publisher(
                Schema::organization()
                    ->name('AgroPro')
                    ->url('https://agropro.org.ua')
            );

        Yii::$app->params['schema'] = $special->toScript();
    }

}

