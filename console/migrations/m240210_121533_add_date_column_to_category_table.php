<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%category}}`.
 */
class m240210_121533_add_date_column_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'date_public', $this->integer()->defaultValue(1683710308));
        $this->addColumn('{{%category}}', 'date_updated', $this->integer()->defaultValue(1707530642));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'date_updated');
        $this->dropColumn('{{%category}}', 'date_updated');
    }
}
