<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tag}}`.
 */
class m241215_215548_add_seo_column_to_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tag}}', 'date_public', $this->integer()->defaultValue(1683710308));
        $this->addColumn('{{%tag}}', 'date_updated', $this->integer()->defaultValue(1732772596));
        $this->addColumn('{{%tag}}', 'seo_title', $this->string());
        $this->addColumn('{{%tag}}', 'seo_description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tag}}', 'date_public');
        $this->dropColumn('{{%tag}}', 'date_updated');
        $this->dropColumn('{{%tag}}', 'seo_title');
        $this->dropColumn('{{%tag}}', 'seo_description');
    }
}
