<?php

namespace frontend\widgets;

use common\models\Contact;
use Yii;
use yii\base\Widget;
use yii\caching\DbDependency;

class SiteFooter extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $language = Yii::$app->language;
        $mobile = Yii::$app->devicedetect->isMobile();
        // $language = Yii::$app->session->get('_language');
        // $cacheKey = 'contact_cache_key_' . $language;
        // $contacts = Yii::$app->cache->get($cacheKey);


        // if ($contacts === false) {

        $contacts = Contact::find()->where(['language' => $language])->one();
        // $contacts = Contact::find()->where(['language' => 'uk'])->one();

        //     Yii::$app->cache->set($cacheKey, $contacts, 3600, new DbDependency([
        //         'sql' => 'SELECT COUNT(*) FROM contacts',
        //     ]));
        // }

        $infoLinks = $this->getInfoLinks();
        $goodLinks = $this->getGoodLinks();
        $backgroundStyle = $this->getBackground($mobile);

        return $this->render('site-footer', [
            'contacts' => $contacts,
            'infoLinks' => $infoLinks,
            'goodLinks' => $goodLinks,
            'mobile' => $mobile,
            'backgroundStyle' => $backgroundStyle,
        ]);
    }

    protected function getInfoLinks()
    {
        return [
            [
                'name' => 'Про нас',
                'url' => '/about'
            ],
            [
                'name' => 'Про доставку',
                'url' => '/delivery'
            ],
            [
                'name' => 'Контакти',
                'url' => '/contact'
            ],
            [
                'name' => 'Повернення',
                'url' => '/order/conditions'
            ],
            [
                'name' => 'Статті',
                'url' => '/blogs'
            ],
        ];
    }

    protected function getGoodLinks()
    {
        return [
            [
                'name' => 'Каталог',
                'url' => '/category/list'
            ],
            [
                'name' => 'Спеціальні пропозиції',
                'url' => '/special'
            ],
            [
                'name' => 'Бренди',
                'url' => '/brands'
            ],
            [
                'name' => 'Теги',
                'url' => '/tag'
            ],
        ];
    }

    protected function getBackground($mobile)
    {
        if ($mobile):
            $class = '';
            $style = '';
        else:
            $class = 'bk-1';
            $style = 'margin: 0 0';
        endif;

        return [
            'class' => $class,
            'style' => $style
        ];
    }
}
