<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%analog_products}}`.
 */
class m231125_113149_create_analog_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%analog_products}}', [

            'product_id' => $this->integer(),
            'analog_product_id' => $this->integer(),
            'PRIMARY KEY(product_id, analog_product_id)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%analog_products}}');
    }
}
