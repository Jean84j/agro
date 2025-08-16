<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%active_pages}}`.
 */
class m240621_155746_add_search_query_column_to_active_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%active_pages}}', 'search_query', $this->string()->defaultValue('No parameter'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%active_pages}}', 'search_query');
    }
}
