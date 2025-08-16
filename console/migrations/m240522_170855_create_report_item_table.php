<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report_item}}`.
 */
class m240522_170855_create_report_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_name' => $this->string(),
            'price' => $this->integer(),
            'volume' => $this->string(10),
            'unit' => $this->string(20),
            'quantity' => $this->integer(),
            'kurs' => $this->integer(),
            'entry_price' => $this->integer(),
            'platform_price' => $this->integer(),
            'discount' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report_item}}');
    }
}
