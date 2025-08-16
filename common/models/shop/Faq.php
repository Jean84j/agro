<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $question
 * @property string|null $answer
 * @property int|null $visible
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'visible'], 'integer'],
            [['answer'], 'string'],
            [['question'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'question' => Yii::t('app', 'Question'),
            'answer' => Yii::t('app', 'Answer'),
            'visible' => Yii::t('app', 'Visible'),
        ];
    }
}
