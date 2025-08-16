<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%seo_pages}}`.
 */
class m241128_073642_add_date_column_to_seo_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%seo_pages}}', 'date_public', $this->integer()->defaultValue(1683710308));
        $this->addColumn('{{%seo_pages}}', 'date_updated', $this->integer()->defaultValue(1732772596));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%seo_pages}}', 'date_public');
        $this->dropColumn('{{%seo_pages}}', 'date_updated');
    }
}
