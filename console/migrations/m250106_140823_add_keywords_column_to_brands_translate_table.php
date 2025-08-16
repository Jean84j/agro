<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%brands_translate}}`.
 */
class m250106_140823_add_keywords_column_to_brands_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%brands_translate}}', 'keywords', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%brands_translate}}', 'keywords');
    }
}
