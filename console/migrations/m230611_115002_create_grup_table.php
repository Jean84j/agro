<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%grup}}`.
 */
class m230611_115002_create_grup_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%grup}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Назва'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%grup}}');
    }
}
