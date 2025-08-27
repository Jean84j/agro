<?php

namespace backend\models;

use common\models\shop\ActivePages;
use common\models\shop\AnalogProducts;
use common\models\shop\Product;
use common\models\shop\ProductProperties;

class ProductsBackend extends Product
{

    public function getProductsAnalog($id)
    {
        return AnalogProducts::find()->where(['product_id' => $id])->count() ?: null;
    }

    public
    function getProductView($slug)
    {
        return ActivePages::find()
            ->select('url_page')
            ->where(['like', 'url_page', $slug])
            ->count();
    }

    /**
     * Вкладки Tab основная информация
     */
    public function getTabs(): array
    {
        $tabs = [
            [
                'id' => 'description',
                'icon' => 'fas fa-info-circle',
                'label' => 'Основна інформація',
                'active' => true,
                'view' => 'basic-information',
            ],
        ];

        if (!$this->isNewRecord) {
            $tabs = array_merge($tabs, [
                ['id' => 'seo', 'icon' => 'fas fa-search-dollar', 'label' => 'Просунення в пошуку', 'view' => 'seo-information'],
                ['id' => 'properties', 'icon' => 'fas fa-list', 'label' => 'Характеристики', 'view' => 'properties-information'],
                ['id' => 'keyword', 'icon' => 'fas fa-key', 'label' => 'Ключові слова', 'view' => 'keywords'],
                ['id' => 'faq', 'icon' => 'far fa-question-circle', 'label' => 'Запитання', 'view' => 'faq'],
            ]);
        }

        return $tabs;
    }

    /**
     * Вкладки Tab основная информация
     */
    public function getSidebarTabs(): array
    {
        $tabs = [
            [
                'id' => 'home',
                'label' => '<i class="fas fa-warehouse"></i>',
                'active' => true,
                'view' => '@backend/views/product/sidebar/home-content',
            ],
        ];

        if (!$this->isNewRecord) {
            $tabs = array_merge($tabs, [
                [
                    'id' => 'profile',
                    'label' => '<i class="fas fa-sitemap"></i>',
                    'view' => '@backend/views/product/sidebar/profile-content',
                ],
                [
                    'id' => 'image',
                    'label' => '<i class="fas fa-images"></i>',
                    'view' => '@backend/views/product/sidebar/images-content',
                ],
                [
                    'id' => 'words',
                    'label' => '<i class="fas fa-spell-check"></i>',
                    'view' => '@backend/views/product/sidebar/words-used-content',
                ],
            ]);
        }

        return $tabs;
    }

    public function getCountUseWords($word)
    {
        if (empty($word)) {
            return 0;
        }

        $text = implode(' ', [
            $this->short_description ?? '',
            $this->description ?? '',
            $this->footer_description ?? '',
            $this->seo_title ?? '',
            $this->h1 ?? '',
        ]);

        return substr_count(mb_strtolower($text), mb_strtolower($word));
    }


    /**
     * Особое внимание к продуктам
     */
    public function hasEmptyParameters(): bool
    {
        $parameters = ProductProperties::find()
            ->select('value')
            ->where(['product_id' => $this->id])
            ->column();

        if (empty($parameters)) {
            return true;
        }

        foreach ($parameters as $value) {
            if ($value === null || $value === '') {
                return true;
            }
        }

        return false;
    }

    public function hasNoBrand(): bool
    {
        return $this->brand_id === null;
    }

    public function shortDescriptionTooSmall(): bool
    {
        return mb_strlen((string)$this->short_description) < 150;
    }

    public function descriptionTooSmall(): bool
    {
        return mb_strlen((string)$this->description) < 1000;
    }

    public function seoTitleInvalid(): bool
    {
        $len = mb_strlen((string)$this->seo_title);
        return $len < 50 || $len > 70;
    }

    public function seoDescriptionInvalid(): bool
    {
        $len = mb_strlen((string)$this->seo_description);
        return $len < 130 || $len > 180;
    }

    public function missingH3(): bool
    {
        return stripos((string)$this->description, '<h3>') === false;
    }

    public function missingKeywords(): bool
    {
        return empty($this->keywords);
    }

    public function missingH1(): bool
    {
        return empty($this->h1);
    }

}