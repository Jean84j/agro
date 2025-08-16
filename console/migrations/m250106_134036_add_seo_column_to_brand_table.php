<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%brand}}`.
 */
class m250106_134036_add_seo_column_to_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%brand}}', 'date_public', $this->integer()->defaultValue(1683710308));
        $this->addColumn('{{%brand}}', 'date_updated', $this->integer()->defaultValue(1732772596));
        $this->addColumn('{{%brand}}', 'seo_title', $this->string());
        $this->addColumn('{{%brand}}', 'seo_description', $this->string());
        $this->addColumn('{{%brand}}', 'description', $this->text());
        $this->addColumn('{{%brand}}', 'keywords', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%brand}}', 'date_public');
        $this->dropColumn('{{%brand}}', 'date_updated');
        $this->dropColumn('{{%brand}}', 'seo_title');
        $this->dropColumn('{{%brand}}', 'seo_description');
        $this->dropColumn('{{%brand}}', 'description');
        $this->dropColumn('{{%brand}}', 'keywords');
    }
}
