<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_properties}}`.
 */
class m230607_123911_create_product_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_properties}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->comment('ID Продукта'),
            'properties' => $this->string()->comment('Властивысть '),
            'value' => $this->string()->comment('Значення')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_properties}}');
    }
}
