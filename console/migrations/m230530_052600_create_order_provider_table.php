<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_provider}}`.
 */
class m230530_052600_create_order_provider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_provider}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Постачальник'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_provider}}');
    }
}
