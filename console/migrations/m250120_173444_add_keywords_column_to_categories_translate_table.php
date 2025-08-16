<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%categories_translate}}`.
 */
class m250120_173444_add_keywords_column_to_categories_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%categories_translate}}', 'keywords', $this->string());
        $this->addColumn('{{%categories_translate}}', 'product_keywords', $this->string());
        $this->addColumn('{{%categories_translate}}', 'product_footer_description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%categories_translate}}', 'keywords');
        $this->dropColumn('{{%categories_translate}}', 'product_keywords');
        $this->dropColumn('{{%categories_translate}}', 'product_footer_description');
    }
}
