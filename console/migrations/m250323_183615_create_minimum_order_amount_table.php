<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%minimum_order_amount}}`.
 */
class m250323_183615_create_minimum_order_amount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%minimum_order_amount}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->decimal(10,2)->notNull()->defaultValue(0)->comment('Минимальная сумма заказа'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%minimum_order_amount}}');
    }
}
