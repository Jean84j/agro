<?php

namespace common\models;

use common\models\shop\Product;
use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property string|null $title Название
 * @property string|null $slug Слаг
 * @property string|null $description Описание
 * @property string|null $image Картинка
 * @property string|null $image_mob Картинка мобилбной версии
 * @property int|null $visible Показ на странице
 * @property int|null $sort Порядок вывода
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'slug'], 'string'],
            [['visible', 'sort'], 'integer'],
            [['title', 'image', 'image_mob'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Название'),
            'description' => Yii::t('app', 'Описание'),
            'image' => Yii::t('app', 'Картинка'),
            'image_mob' => Yii::t('app', 'Картинка мобилбной версии'),
            'visible' => Yii::t('app', 'Показ на странице'),
            'sort' => Yii::t('app', 'Порядок вывода'),
            'slug' => Yii::t('app', 'Слаг'),
        ];
    }
    public function getSliderPrice($slug) {
        $product = Product::find()->select(['price', 'currency'])->where(['slug' => $slug])->one();
        if($product->currency === 'UAH'){
            return $product->price;
        }else{
            return floatval($product->price) * floatval(Settings::currencyRate($product->currency));
        }
    }

    public function getSliderOldPrice($slug) {
        $product = Product::find()->select(['old_price', 'currency'])->where(['slug' => $slug])->one();
        if($product->currency === 'UAH'){
            return $product->old_price;
        }else{
            return floatval($product->old_price) * floatval(Settings::currencyRate($product->currency));
        }
    }
}
