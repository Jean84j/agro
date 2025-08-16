<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_packaging}}`.
 */
class m250124_204650_create_product_packaging_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_packaging}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'product_variant_id' => $this->integer(),
            'volume' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_packaging}}');
    }
}
