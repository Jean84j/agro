<?php

namespace frontend\widgets;

use common\models\Contact;
use common\models\shop\Category;
use Yii;
use yii\base\Widget;
use yii\caching\DbDependency;

class SiteHeader extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $session = Yii::$app->session;
        $language = Yii::$app->language;
        $compareList = $session->get('compareList', []);
        $compareList = count($compareList);
        $wishList = $session->get('wishList', []);
        $wishList = count($wishList);

        $categories = Category::find()->where(['visibility' => 1])->all();

        $cacheKey = 'contact_cache_key';
        $contacts = Yii::$app->cache->get($cacheKey);

        if ($contacts === false) {
            $contacts = Contact::find()->one();

            Yii::$app->cache->set($cacheKey, $contacts, 3600, new DbDependency([
                'sql' => 'SELECT COUNT(*) FROM contacts',
            ]));
        }

        if ($language !== 'uk') {
            $categories = $this->getCategoriesTranslate($categories, $language);
        }

        $path = Yii::$app->request->pathInfo;
        $lang = strtoupper(Yii::$app->language);
        $isMobile = Yii::$app->devicedetect->isMobile();
        $navLinks = $this->getNavLinks();
        $topBarLinks = $this->getTopBarLinks();
        $itemsMenu = $this->getItemsMobileMenu();

        return $this->render('site-header/header',
            [
                'contacts' => $contacts,
                'itemsMenu' => $itemsMenu,
                'navLinks' => $navLinks,
                'topBarLinks' => $topBarLinks,
                'compareList' => $compareList,
                'wishList' => $wishList,
                'categories' => $categories,
                'path' => $path,
                'lang' => $lang,
                'isMobile' => $isMobile,
            ]);
    }

    protected function getCategoriesTranslate($categories, $language)
    {
        foreach ($categories as $category) {
            if ($category) {
                $translationCat = $category->getTranslation($language)->one();
                if ($translationCat) {
                    if ($translationCat->name) {
                        $category->name = $translationCat->name;
                    }
                }
                if ($category->parents) {
                    foreach ($category->parents as $parent) {
                        if ($parent !== null) {
                            $translationCatParent = $parent->getTranslation($language)->one();
                            if ($translationCatParent) {
                                $parent->name = $translationCatParent->name;
                            }
                        }
                    }
                }
            }
        }
        return $categories;
    }

    protected function getNavLinks(): array
    {
        return [
            [
                'name' => 'Спеціальні пропозиції',
                'url' => '/special'
            ],
            [
                'name' => 'Доставка',
                'url' => '/delivery'
            ],
            [
                'name' => 'Зв’язок з нами',
                'url' => '/contact'
            ],
            [
                'name' => 'Статті',
                'url' => '/blogs'
            ],
        ];
    }

    protected function getTopBarLinks(): array
    {
        return [
            [
                'name' => 'Про нас',
                'url' => '/about',
            ],
            [
                'name' => 'Контакти',
                'url' => '/contact',
            ],
            [
                'name' => 'Доставка Оплата',
                'url' => '/delivery',
            ],
            [
                'name' => 'Теги',
                'url' => '/tag',
            ],
            [
                'name' => 'Бренди',
                'url' => '/brands',
            ],
            [
                'name' => 'Статті',
                'url' => '/blogs',
            ],
        ];
    }

    protected function getItemsMobileMenu(): array
    {
        return [
            [
                'url' => '/special',
                'name' => Yii::t('app', 'Спеціальні пропозиції'),
                'icon' => '<i class="fas fa-tags"></i>',
            ],
            [
                'url' => '/delivery',
                'name' => Yii::t('app', 'Доставка та оплата'),
                'icon' => '<i class="fas fa-truck"></i>',
            ],
            [
                'url' => '/about',
                'name' => Yii::t('app', 'Про нас'),
                'icon' => '<i class="fas fa-address-card"></i>',
            ],
            [
                'url' => '/contact',
                'name' => Yii::t('app', 'Зв’язок з нами'),
                'icon' => '<i class="fas fa-phone-square-alt"></i>',
            ],
            [
                'url' => '/blogs',
                'name' => Yii::t('app', 'Статті'),
                'icon' => '<i class="fas fa-file-alt"> </i>',
            ]
        ];
    }
}
