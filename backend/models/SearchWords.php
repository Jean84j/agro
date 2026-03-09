<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "search_words".
 *
 * @property int $id
 * @property string|null $word
 * @property int|null $counts_query
 */
class SearchWords extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'search_words';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['word', 'counts_query'], 'default', 'value' => null],
            [['counts_query'], 'integer'],
            [['word'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => 'Word',
            'counts_query' => 'Counts Query',
        ];
    }

}
