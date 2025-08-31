<?php

namespace backend\helpers;

use Yii;

class ProductWarnings
{
    public static function getList(): array
    {
        $seoRules = Yii::$app->params['seoRules'];

        return [
            'hasEmptyParameters'   => ['Незаповнені характеристики', 'red'],
            'hasNoBrand'           => ['Невказаний бренд', '#ffcc00'],
            'shortDescriptionTooSmall' => ['Короткий опис < 150 знаків', '#40ff00'],
            'descriptionTooSmall'  => ['Опис < 1000 знаків', '#02ade1'],
            'seoTitleInvalid'      => ['SEO Тайтл < ' . $seoRules['seo_title']['min'] . ' или > ' . $seoRules['seo_title']['max'], '#9607f5'],
            'seoDescriptionInvalid'=> ['SEO Дескрип < ' . $seoRules['seo_description']['min'] . ' или > ' . $seoRules['seo_description']['max'], '#e1029e'],
            'seoH1Invalid'         => ['SEO H1 < ' . $seoRules['seo_h1']['min'] . ' или > ' . $seoRules['seo_h1']['max'], '#e2099e'],
            'missingH3'            => ['Нет Н3 в описании', '#dc79b7'],
            'missingKeywords'      => ['Нема ключових слів', '#ed490a'],
            'missingH1'            => ['Нема Н1 заголовку', '#0be5dd'],
        ];
    }
}
