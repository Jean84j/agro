<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contacts}}`.
 */
class m230420_082943_add_comment_two_column_to_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contacts}}', 'comment_two', $this->text()->comment('Коментарій другий'));
        $this->addColumn('{{%contacts}}', 'work_time_short', $this->string()->comment('Години праці короткі'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contacts}}', 'comment_two');
        $this->dropColumn('{{%contacts}}', 'work_time_short');
    }
}
