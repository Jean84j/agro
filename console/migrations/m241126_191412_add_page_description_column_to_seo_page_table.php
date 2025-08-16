<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%seo_pages}}`.
 */
class m241126_191412_add_page_description_column_to_seo_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%seo_pages}}', 'page_description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%seo_pages}}', 'page_description');
    }
}
