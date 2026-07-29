<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%status}}`.
 */
class m260729_200544_add_style_column_to_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%status}}', 'icon', $this->string(50));
        $this->addColumn('{{%status}}', 'color', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%status}}', 'icon');
        $this->dropColumn('{{%status}}', 'color');
    }
}
