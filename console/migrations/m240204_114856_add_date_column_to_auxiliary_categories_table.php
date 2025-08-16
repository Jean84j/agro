<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%auxiliary_categories}}`.
 */
class m240204_114856_add_date_column_to_auxiliary_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%auxiliary_categories}}', 'date_public', $this->integer()->defaultValue(1706867468));
        $this->addColumn('{{%auxiliary_categories}}', 'date_updated', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%auxiliary_categories}}', 'date_updated');
        $this->dropColumn('{{%auxiliary_categories}}', 'date_updated');
    }
}
