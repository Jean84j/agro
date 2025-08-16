<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%properties_name}}`.
 */
class m250108_132222_create_properties_name_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%properties_name}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'sort' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%properties_name}}');
    }
}
