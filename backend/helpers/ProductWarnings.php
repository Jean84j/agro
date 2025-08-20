<?php

namespace backend\helpers;

class ProductWarnings
{
    public static function getList(): array
    {
        return [
            'hasEmptyParameters'   => ['Незаповнені характеристики', 'red'],
            'hasNoBrand'           => ['Невказаний бренд', '#ffcc00'],
            'shortDescriptionTooSmall' => ['Короткий опис < 150 знаків', '#40ff00'],
            'descriptionTooSmall'  => ['Опис < 1000 знаків', '#02ade1'],
            'seoTitleInvalid'      => ['SEO Тайтл < 50 или > 70', '#9607f5'],
            'seoDescriptionInvalid'=> ['SEO Дескрип < 130 или > 180', '#e1029e'],
            'missingH3'            => ['Нет Н3 в описании', '#dc79b7'],
            'missingKeywords'      => ['Нема ключових слів', '#ed490a'],
            'missingH1'            => ['Нема Н1 заголовку', '#0be5dd'],
        ];
    }
}
