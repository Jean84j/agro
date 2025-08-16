<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%np_warehouses}}`.
 */
class m231014_125853_create_np_warehouses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%np_warehouses}}', [
            'id' => $this->primaryKey(),
            'cityRef' => $this->string(),
            'description' => $this->string(),
            'shortAddress' => $this->string(),
            'Number' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%np_warehouses}}');
    }
}
