<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_pay_ment}}`.
 */
class m230319_162153_create_order_pay_ment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_pay_ment}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_pay_ment}}');
    }
}
