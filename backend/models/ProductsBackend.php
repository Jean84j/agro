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