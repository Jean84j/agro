<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_products}}`.
 */
class m231105_084424_create_post_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_products}}', [
            'post_id' => $this->integer(),
            'product_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_products}}');
    }
}
