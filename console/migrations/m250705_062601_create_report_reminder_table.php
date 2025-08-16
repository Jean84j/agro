<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report_reminder}}`.
 */
class m250705_062601_create_report_reminder_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report_reminder}}', [
            'id' => $this->primaryKey(),
            'report_id' => $this->integer(),
            'date' => $this->integer(),
            'event' => $this->string(),
            'status' => $this->boolean(),
            'comment' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report_reminder}}');
    }
}
