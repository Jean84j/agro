<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_grup}}`.
 */
class m230611_115236_create_product_grup_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_grup}}', [
            'product_id' => $this->integer()->comment('ID продукту'),
            'grup_id' => $this->integer()->comment('ID групи'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_grup}}');
    }
}
