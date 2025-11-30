<?php

namespace frontend\controllers;

use common\models\Settings;
use common\models\shop\Product;
use Yii;
use yii\db\Expression;
use yii\helpers\FileHelper;
use yii\helpers\Url;

class SpecialController extends BaseFrontendController
{
    public function actionView()
    {
        $language = Yii::$app->language;

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

        $products = $this->translateProduct($products, $language);

        $seo = Settings::seoPageTranslate('special');
        $type = 'product.group';
        $title = $seo->title;
        $description = $seo->description;
        $image = '';
        $keywords = '';
        $url = Url::canonical();
        Settings::setMetamaster($type, $title, $description, $image, $keywords, $url);

        $page_description = $seo->page_description;

        $files = $this->getRelativeFiles('@webroot/images/special');

        return $this->render('view', compact([
            'products',
            'products_all',
            'pages',
            'language',
            'page_description',
            'files'
        ]));
    }

    private function getRelativeFiles(string $aliasPath, bool $recursive = false): array
    {
        $path = Yii::getAlias($aliasPath);
        $webroot = str_replace('\\', '/', Yii::getAlias('@webroot'));

        $files = FileHelper::findFiles($path, [
            'recursive' => $recursive,
        ]);

        $relative = array_map(function ($file) use ($webroot) {
            $file = str_replace('\\', '/', $file);
            return str_replace($webroot, '', $file);
        }, $files);

        sort($relative);

        return $relative;
    }

}

