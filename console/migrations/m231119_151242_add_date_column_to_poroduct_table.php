<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 */
class m231119_151242_add_date_column_to_poroduct_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'date_public', $this->integer()->defaultValue(1672751792));
        $this->addColumn('{{%product}}', 'date_updated', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'date_updated');
        $this->dropColumn('{{%product}}', 'date_updated');
    }
}
