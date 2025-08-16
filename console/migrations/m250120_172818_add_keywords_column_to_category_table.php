<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%category}}`.
 */
class m250120_172818_add_keywords_column_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'keywords', $this->string());
        $this->addColumn('{{%category}}', 'product_keywords', $this->string());
        $this->addColumn('{{%category}}', 'product_footer_description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'keywords');
        $this->dropColumn('{{%category}}', 'product_keywords');
        $this->dropColumn('{{%category}}', 'product_footer_description');
    }
}
